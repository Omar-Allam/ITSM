<?php

namespace App\Reports;

use Carbon\Carbon;

class LotByTechnicianSummaryReport extends LotByTechnicianDetailsReport
{
    protected $view = 'reports.lot_summary_by_technician';

    protected function fields()
    {
        $workStart = Carbon::parse(config('worktime.start'));
        $workEnd = Carbon::parse(config('worktime.end'));
        $workHours = $workEnd->diffInHours($workStart);

        $this->query->selectRaw("tech.name, (sla.due_days * $workHours) + sla.due_hours + (sla.due_minutes / 60) as sla_time");
    }

    protected function sort()
    {
        $this->query->orderBy('tech.name')->orderBy('t.id');
    }

    protected function group()
    {
        $this->query->groupBy(['tech.name']);
    }
}