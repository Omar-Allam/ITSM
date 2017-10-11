<?php
/**
 * Created by PhpStorm.
 * User: omar
 * Date: 10/11/17
 * Time: 8:16 AM
 */

namespace App\Observers;

use App\Attachment;
use App\ExtractImages;
use App\Helpers\ServiceDeskApi;
use App\Jobs\TicketReplyJob;
use App\Mail\AttachmentsReplyJob;
use App\Ticket;
use App\TicketLog;
use App\TicketReply;
use Carbon\Carbon;

class TicketReplyObserver
{
    public function creating(TicketReply $reply)
    {
        if ($reply->user_id == $reply->ticket->requester_id) {
            if ($reply->status_id) {
                $reply->ticket->status_id = $reply->status_id;
            } else {
                $reply->status_id = 1;
                $reply->ticket->status_id = 1;
            }
        } elseif ($reply->user_id == $reply->ticket->technician_id) {
            $this->handleTechnician($reply);
        }

        $extract_image = new ExtractImages($reply->content);
        $reply->content = $extract_image->extract();
        TicketLog::addReply($reply);
        $reply->ticket->save();
    }

    public function created(TicketReply $reply)
    {
        Attachment::uploadFiles(Attachment::TICKET_REPLY_TYPE, $reply->id);
        dispatch(new TicketReplyJob($reply));
    }

    protected function handleTechnician(TicketReply $reply){
        if ($reply->ticket->sdp_id) {

            $sdp = new ServiceDeskApi();
            $reply_id = $sdp->addReply($reply);

            if ($reply->status_id) {
                $reply->ticket->status_id = $reply->status_id;

                if ($reply->status_id == 7 || $reply->status_id == 9) {
                    $reply->ticket->resolve_date = Carbon::now();
                }
            }else{
                $reply->status_id = $reply->ticket->status_id;
            }

            if ($reply->attachments->count()) {
                \Mail::send(new AttachmentsReplyJob($reply->attachments));
            }
            $reply->sdp_id = $reply_id;
        }
        else {

            if ($reply->status_id) {
                $reply->ticket->status_id = $reply->status_id;

                if ($reply->status_id == 7 || $reply->status_id == 9) {
                    $reply->ticket->resolve_date = Carbon::now();
                }
            }else{
                $reply->status_id = $reply->ticket->status_id;
            }

        }
    }
}