<?php

namespace App\Jobs;

use App\Sla;
use App\Ticket;
use Carbon\Carbon;

class ApplySLA extends MatchCriteria
{
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;

        Carbon::setWeekendDays([Carbon::SATURDAY, Carbon::FRIDAY]);
    }

    public function handle()
    {
        $sla = $this->fetchSLA();

        if ($sla) {
            $this->ticket->sla_id = $sla->id;
            $this->ticket->due_date = $this->calculateDueDate($sla);
            $this->ticket->first_response_date = $this->calculateFirstResponseDate($sla);
        } else {
            $this->ticket->sla_id = null;
            $this->ticket->due_date = null;
            $this->ticket->first_response_date = null;
        }

        Ticket::flushEventListeners();
        $this->ticket->save();
    }

    protected function fetchSLA()
    {
        $agreements = Sla::with('criterions')->get();

        foreach ($agreements as $sla) {
            if ($this->matchSLA($sla)) {
                return $sla;
            }
        }

        return false;
    }

    protected function matchSLA($sla)
    {
        foreach ($sla->criterions as $criterion) {
            if (!$this->checkCriterion($criterion)) {
                return false;
            }
        }

        return true;
    }

    protected function calculateFirstResponseDate(Sla $sla)
    {
        $date = clone $this->ticket->created_at;

        for ($d = 0; $d < $sla->response_days; ++ $d) {
            $date->addDay();
            if (!$sla->critical && $date->isWeekend()) {
                $date->addDay();
            }
        }

        for ($h = 0; $h < $sla->response_hours; ++$h) {
            $date->addHour();
            if (!$sla->critical && $date->isWeekend()) {
                $date->addDay();
            }
        }

        for ($m = 0; $m < $sla->response_minutes; ++$m) {
            $date->addMinute();
            if (!$sla->critical && $date->isWeekend()) {
                $date->addDay();
            }
        }

        return $date;
    }

    /**
     * @param $sla
     *
     * @return Carbon
     */
    protected function calculateDueDate(Sla $sla)
    {
        $date = clone $this->ticket->created_at;

        for ($d = 0; $d < $sla->due_days; ++ $d) {
            $date->addDay();
            if (!$sla->critical && $date->isWeekend()) {
                $date->addDay();
            }
        }

        for ($h = 0; $h < $sla->due_hours; ++$h) {
            $date->addHour();
            if (!$sla->critical && $date->isWeekday()) {
                $date->addDay();
            }
        }

        for ($m = 0; $m < $sla->due_minutes; ++$m) {
            $date->addMinute();
            if (!$sla->critical && $date->isWeekend()) {
                $date->addDay();
            }
        }

        return $date;
    }

    
}
