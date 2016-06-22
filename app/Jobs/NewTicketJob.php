<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Ticket;
use Illuminate\Mail\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTicketJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Ticket
     */
    private $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function handle()
    {
        \Mail::send('emails.ticket.new-ticket', ['ticket' => $this->ticket], function(Message $msg) {
            $ticket = $this->ticket;
            $msg->subject('A new ticket #' . $ticket->id . ' has been created for you');
            $msg->to($ticket->requester->email);
        });

        dispatch(new TicketAssigned($this->ticket));
    }
}
