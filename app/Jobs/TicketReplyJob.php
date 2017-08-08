<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\TicketReply;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TicketReplyJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var TicketReply
     */
    protected $reply;

    public function __construct(TicketReply $reply)
    {
        $this->reply = $reply;
    }

    public function handle()
    {
        if (!$this->reply->sdp_id && $this->reply->user_id == $this->reply->ticket->technician_id) {
            return false;
        }
        
        \Mail::send('emails.ticket.reply', ['reply' => $this->reply], function(Message $msg) {
            $ticket = $this->reply->ticket;
            $msg->subject('Re: Ticket #' . $ticket->id);

            $to = [];
            if (!$this->reply->sdp_id) {
                $to = [$ticket->requester->email ?? ''];
            }
            
            if ($this->reply->user_id != $this->reply->ticket->technician_id) {
                $to[] = $ticket->technician->email;
            }

            $msg->to(array_filter($to));
        });
    }
}
