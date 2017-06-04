<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EscalationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $ticket;
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }


    public function build()
    {

        return $this->view('emails.ticket.escalation')->with('ticket',$this->ticket);
    }
}
