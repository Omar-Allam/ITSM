<?php

namespace App\Providers;

use App\Attachment;
use App\Helpers\ServiceDeskApi;
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
                if ($reply->status_id == 7) {
                    $reply->ticket->resolve_date = Carbon::now();
                }
            }
            
            TicketLog::addReply($reply);
            $reply->ticket->save();
        });

        TicketReply::created(function(TicketReply $reply) {
            Attachment::uploadFiles(Attachment::TICKET_REPLY_TYPE, $reply->id);

            if ($reply->ticket->sdp_id) {
                $sdp = new ServiceDeskApi();

                if ($reply->status_id == 7) {
                    $sdp->addResolution($reply);
                } else {
                    $sdp->addReply($reply);
                }
            } else {
                dispatch(new TicketReplyJob($reply));
            }
        });
    }

    public function register()
    {
        //
    }
}
