<?php

namespace App\Providers;

use App\Attachment;
use App\ExtractImages;
use App\Helpers\ServiceDeskApi;
use App\Images;
use App\Jobs\TicketReplyJob;
use App\Status;
use App\TicketLog;
use App\TicketReply;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class TicketReplyEventsProvider extends ServiceProvider
{
    public function boot()
    {
        TicketReply::creating(function (TicketReply $reply) {
            if (!$reply->status_id) {
                $reply->status_id = $reply->ticket->status_id;
            } else {
                $reply->ticket->status_id = $reply->status_id;
                if ($reply->status_id == 7 || $reply->status_id == 9) {
                    $reply->ticket->resolve_date = Carbon::now();
                }
            }
            $extract_image = new ExtractImages($reply->content);
            $reply->content = $extract_image->extract();
            TicketLog::addReply($reply);
            $reply->ticket->save();
        });

        TicketReply::created(function (TicketReply $reply) {
            Attachment::uploadFiles(Attachment::TICKET_REPLY_TYPE, $reply->id);
            if ($reply->sdp_id) {
                $sdp = new ServiceDeskApi();

                if ($reply->status_id == 7) {
                    $sdp->addResolution($reply);
                } elseif ($reply->status_id == 9) {
                    $sdp->addCompletedWithoutSolution($reply);
                }elseif (in_array($reply->status_id,[4,5,6])){
                    $sdp->addOnHoldStatus($reply);
                } else {
                    if (!$reply->sdp_id) {
                        $sdp->addReply($reply);
                    }
                }

                if ($reply->user_id != $reply->ticket->technician_id) {
                    dispatch(new TicketReplyJob($reply));
                }
            } else{
                dispatch(new TicketReplyJob($reply));
            }
        });
    }

    public function register()
    {
        //
    }
}
