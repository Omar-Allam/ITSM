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
        \Mail::send('emails.ticket.reply', ['reply' => $this->reply], function(Message $msg) {
            $ticket = $this->reply->ticket;
            $msg->subject('Re: Ticket #' . $ticket->id);

            $to = [$ticket->requester->email ?? ''];
            if (!$ticket->sdp_id) {
                $to[] = $ticket->requester->email;
            }

            $msg->to(array_filter($to));
        });
    }
}
