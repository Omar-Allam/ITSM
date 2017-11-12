<?php

namespace App\Jobs;

use App\EscalationLevel;
use App\TicketLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class EscalationJob extends Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }


    public function handle()
    {
        if ($this->ticket->sla) {
            $escalations = $this->ticket->sla->escalations;
            /** @var EscalationLevel $escalation */

            foreach ($escalations as $escalation) {
                if ($this->ticket->shouldEscalate($escalation)) {
                    $this->escalate($escalation);
                }

            }
        }
    }

    public function escalate($escalation)
    {
        dispatch(new SendEscalationNotification($this->ticket,$escalation));

        TicketLog::addEscalationLog($this->ticket,$escalation);

        if ($escalation->assign) {
            $this->ticket->update(['technician_id' => $escalation->assign]);
            dispatch(new TicketAssigned($this->ticket));
        }

    }
}
