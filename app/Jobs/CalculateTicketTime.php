<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Status;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CalculateTicketTime extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    const MINUTES_IN_DAY = 1440;

    /**
     * @var Ticket
     */
    private $ticket;


    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;

        Carbon::setWeekendDays([Carbon::FRIDAY, Carbon::SATURDAY]);
    }

    public function handle()
    {
        $today = Carbon::now();


        if ($this->ticket->isOpen() && $this->ticket->logs->count() == 0) {
            if (!$this->ticket->sla->critical && !in_array($today->dayOfWeek, Carbon::getWeekendDays())) {
                $this->ticket->time_spent = $this->calculateDiff($this->ticket->created_at, $today);
            }
//        } elseif ($this->ticket->resolve_date && $this->ticket->logs->count() == 1) {
//            if (!$this->ticket->sla->critical && in_array($this->ticket->resolve_date->dayOfWeek, Carbon::getWeekendDays())) {
//                $this->ticket->time_spent = $this->calculateDiff($this->ticket->created_at, $this->ticket->resolve_date);
//            }
        } else {
            $this->ticket->time_spent = $this->parseLogs();
        }

        Ticket::flushEventListeners();
        $this->ticket->save();
    }

    protected function calculateDiff(Carbon $start, Carbon $end)
    {
        $diff = $end->diffInMinutes($start);

        $sameDay = $start->format('dmY') == $end->format('dmY');

        // removes the weekends from the calculated time
        // if same day then it is a work day no need for calculation
        // if SLA is critical then it should not respect service days or hours
        $critical = !empty($this->ticket->sla->critical);
        if (!($sameDay || $critical)) {
            $days = ceil($diff / self::MINUTES_IN_DAY);
            $day = clone $start;
            for ($i = 0; $i < $days; ++$i) {
                $day->addDay();
                if (in_array($day->dayOfWeek, Carbon::getWeekendDays())) {
                    $diff -= self::MINUTES_IN_DAY;
                }
            }
        }

        return $diff;
    }

    protected function parseLogs()
    {
        /** @var Collection $logs */
        $logs = $this->ticket->logs;
        $diff = 0;
        $start = $this->ticket->created_at;
        $lastStatus = Status::OPEN;

        foreach ($logs as $log) {
            if (!$log->status->isOpen() && $lastStatus == Status::OPEN) {
                $diff += $this->calculateDiff($start, $log->created_at);
            }

            $start = $log->created_at;
            $lastStatus = $log->status->type;
        }

        $today = Carbon::now();
        $calculate = !in_array($today->dayOfWeek, Carbon::getWeekendDays()) || $this->ticket->sla->critical;
        $lastLog = $logs->last();
        if ($lastLog->status->isOpen() && $calculate) {
            $diff += $this->calculateDiff($lastLog->created_at, $today);
        }

        return $diff;
    }
}
