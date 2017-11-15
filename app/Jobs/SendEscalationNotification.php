<?php

namespace App\Jobs;

use App\EscalationLevel;
use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEscalationNotification extends Job
{
    private $ticket;
    private $escalation;

    public function __construct(Ticket $ticket,EscalationLevel $escalation)
    {
        $this->ticket = $ticket;
        $this->escalation = $escalation;
    }

    public function handle()
    {
            \Mail::send('emails.ticket.escalation', ['ticket' => $this->ticket], function(Message $msg) {
                $ticket = $this->ticket;
                $msg->subject('SLA escalation warning notification. Request due at '.$ticket->due_date->format('d/m/Y h:m a'));
                $msg->to($this->escalation->user->email);
            });

    }
}
