<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Ticket;
use Illuminate\Mail\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketAssigned extends Job implements ShouldQueue
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
        \Mail::send('emails.ticket.assigned', ['ticket' => $this->ticket], function(Message $msg) {
            $ticket = $this->ticket;
            $msg->subject('Ticket #' . $ticket->id . ' has been assigned to you');
            $msg->to($ticket->technician->email);
        });
    }
}
