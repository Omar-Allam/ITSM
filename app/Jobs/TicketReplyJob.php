<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\TicketReply;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        \Mail::send('emails.ticket.reply', ['reply' => $this->reply], function($msg) {
            $ticket = $this->reply->ticket;

            $msg->subject('Re: Ticket #' . $ticket->id);

            $msg->to([$ticket->requester->email, $ticket->technician->email]);
        });
    }
}
