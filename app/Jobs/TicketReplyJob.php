<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\TicketReply;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TicketReplyJob extends Job //implements ShouldQueue
{
    //use InteractsWithQueue, SerializesModels;

    /**
     * @var TicketReply
     */
    protected $reply;
    protected $to;
    public function __construct(TicketReply $reply)
    {
        $this->reply = $reply;
    }

    public function handle()
    {
        $this->to = [];

        if ($this->reply->user_id == $this->reply->ticket->requester_id) {
            $ticket = $this->reply->ticket;
            $this->to= [$ticket->technician->email];
        }
        else {
            if ($this->reply->user_id != $this->reply->ticket->technician_id) {
                if ($this->reply->ticket->sdp_id) {
                    $ticket = $this->reply->ticket;
                    $this->to  = [$ticket->technician->email];
                }
                else {
                    $ticket = $this->reply->ticket;
                    $this->to  = [$ticket->technician->email, $ticket->requester->email];
                }
            }
        }

        \Mail::send('emails.ticket.reply', ['reply' => $this->reply], function (Message $msg) {
            $ticket = $this->reply->ticket;
            $subject = 'Re: Ticket #' . $ticket->id . ' ' . $this->reply->ticket->subject;
            if ($this->reply->ticket->sdp_id) {
                $subject .= " [Request ##{$this->reply->ticket->sdp_id}##]";
            }

            $msg->subject($subject);
            $msg->to($this->to);
        });
    }
}
