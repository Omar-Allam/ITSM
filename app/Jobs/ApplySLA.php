<?php

namespace App\Jobs;

use App\Sla;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ApplySLA extends Job
{

    /**
     * @var Ticket
     */
    private $ticket;

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
            $this->ticket->save();
        }
    }

    protected function fetchSLA()
    {
        $agreements = Sla::with('criterions')->get();

        foreach ($agreements as $sla) {
            if ($this->checkSLA($sla)) {
                return $sla;
            }
        }

        return false;
    }

    protected function checkSLA($sla)
    {
        foreach ($sla->criterions as $criterion) {
            if (!$this->checkCriterion($criterion)) {
                return false;
            }
        }

        return true;
    }

    protected function checkCriterion($criterion)
    {
        $result = false;
        $attribute = $this->ticket->getAttribute($criterion->field);
        switch ($criterion->operator) {
            case 'is':
                $result = $this->is($attribute, $criterion);
                break;
            case 'isnot':
                $result = ! $this->is($attribute, $criterion);
                break;
            case 'contains':
                $result = $this->contains($attribute, $criterion);
                break;
            case 'notcontain':
                $result = ! $this->contains($attribute, $criterion);
                break;
            case 'starts':
                $result = $this->starts($attribute, $criterion);
                break;
            case 'ends':
                $result = $this->ends($attribute, $criterion);
                break;
        }

        return $result;
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

    protected function is($attribute, $criterion)
    {
        $tokens = explode(',', $criterion->value);

        return in_array($attribute, $tokens);
    }

    protected function contains($attribute, $criterion)
    {
        return Str::contains(Str::lower($attribute), Str::lower($criterion->value));
    }

    protected function starts($attribute, $criterion)
    {
        return Str::startsWith(Str::lower($attribute), Str::lower($criterion->value));
    }

    protected function ends($attribute, $criterion)
    {
        return Str::endsWith(Str::lower($attribute), Str::lower($criterion->value));
    }

}
