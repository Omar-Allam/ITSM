<?php

namespace App\Console\Commands;

use App\TicketApproval;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EscalateApprovals extends Command
{
    protected $signature = 'approvals:escalate';

    protected $description = 'Escalate approvals';

    public function handle()
    {
        $approvals = TicketApproval::with('ticket.sla')->where('status', TicketApproval::PENDING_APPROVAL)->get();
        $now = Carbon::now();
        foreach ($approvals as $approval) {
            if ($approval->ticket->sla) {
                $date = $this->calculateDueDate($approval);
                if ($date && $now->gte($date)) {
                    $approval->escalate();
                }
            }
        }
    }

    protected function calculateDueDate($approval)
    {
        $date = clone $approval->created_at;
        $sla = $approval->ticket->sla;

        $approvalTime = $sla->approval_days * 8 + $sla->approval_hours + $sla->approval_minutes;
        if (!$approvalTime) {
            return false;
        }

        $date->addDays($sla->approval_days);
        $date->addHour($sla->approval_hours);
        $date->addMinute($sla->approval_minutes);

        while (!$sla->critical && $date->isWeekend()) {
            $date->addDay();
        }

        return $date;
    }
}
