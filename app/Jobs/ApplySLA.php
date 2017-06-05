<?php

namespace App\Jobs;

use App\Sla;
use App\Ticket;
use Carbon\Carbon;

class ApplySLA extends MatchCriteria
{
    /** @var Ticket */
    protected $ticket;

    /** @var Carbon  */
    protected $workStartTime;

    /** @var Carbon  */
    protected $workEndTime;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;

        Carbon::setWeekendDays([Carbon::SATURDAY, Carbon::FRIDAY]);

        $this->workStartTime = Carbon::parse(config('worktime.end'));
        $this->workEndTime = Carbon::parse(config('worktime.end'));
    }

    public function handle()
    {
        $sla = $this->fetchSLA();

        if ($sla) {
            $this->ticket->sla_id = $sla->id;
            $this->ticket->due_date = $this->calculateTime($sla->due_days, $sla->due_hours, $sla->due_minutes, $sla->critical);
            $this->ticket->first_response_date = $this->calculateTime($sla->response_days, $sla->response_hours, $sla->response_minutes);
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
            if ($this->match($sla)) {
                return $sla;
            }
        }

        return false;
    }

    protected function calculateTime($days, $hours, $minutes, $critical = false)
    {
        $date = clone $this->ticket->created_at;

        $workStart = config('worktime.start');
        $workEnd = config('worktime.end');

        if (!$critical) {
            // If it is not critical and time is outside working hours
            // move the time to nearest working hour possible.
            $todayStart = Carbon::parse($workStart);
            $todayEnd = Carbon::parse($workEnd);

            if ($date->lt($todayStart)) {
                // If it is before work start move to work start
                $date->setTimeFromTimeString($workStart);
            } elseif ($date->gt($todayEnd)) {
                // If it is after working hours move to next day's start
                $date->addDay()->setTimeFromTimeString($workStart);
            }
        }

        $date->addDays($days);
        $date->addHours($hours);
        $date->addMinute($minutes);

        $end = clone($date);
        $end->setTimeFromTimeString($workEnd);

        if ($date->gt($end)) {
            // If the due date is after working hours, move to next day
            $diff = $date->diffInMinutes($end);
            $date->addDay();
            $date->setTimeFromTimeString($workStart)->addMinutes($diff);
        }

        while (!$critical && $date->isWeekend()) {
            // As long as due date is in a weekend move due time to next day
            $date->addDay();
        }

        return $date;
    }
}
