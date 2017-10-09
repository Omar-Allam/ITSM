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

class CalculateTicketTime extends Job
{   
    const MINUTES_IN_DAY = 1440;

    protected $workingMinutes = 1440;

    protected $workStart = '00:00';

    protected $workEnd = '23:59';

    /** @var bool */
    protected $critical;


    /**
     * @var Ticket
     */
    private $ticket;


    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;

        Carbon::setWeekendDays([Carbon::FRIDAY, Carbon::SATURDAY]);

        $this->critical = $ticket->sla->critical ?? false;

        if (!$this->critical) {
            $this->workStart = config('worktime.start');
            $this->workEnd = config('worktime.end');
        }

        $this->workingMinutes = Carbon::parse($this->workEnd)->diffInMinutes(Carbon::parse($this->workStart));
    }

    public function handle()
    {
        $now = Carbon::now();

        if ($this->ticket->logs->count() == 0) {
            $start = $this->critical? $this->ticket->created_at : $this->ticket->start_time;
            $this->ticket->time_spent = $this->calculateDiff($start, $now);
        } else {
            $this->ticket->time_spent = $this->parseLogs();
        }

        if ($this->ticket->sla && $this->ticket->time_spent > $this->ticket->sla->minutes) {
            $this->ticket->overdue = true;
        } else {
            $this->ticket->overdue = false;
        }

        $this->ticket->setApplySla(false)->setApplyRules(false)->stopLog(true);
        $this->ticket->save();

        return $this->ticket->time_spent;
    }

    protected function calculateDiff(Carbon $start, Carbon $end)
    {
        if ($this->critical) {
            return $end->diffInMinutes($start);
        }

        
        $transDay = clone $start;
        $endStr = $end->format("Ymd");
        $startStr = $transDay->format("Ymd");
        $diff = 0;

        $firstDay = true;
        while ($endStr >= $startStr) {
            if ($transDay->isWeekday()) {
                $transDayStart = clone $transDay;
                $transDayEnd = clone $transDay;

                $transDayStart->setTimeFromTimeString($this->workStart);
                $transDayEnd->setTimeFromTimeString($this->workEnd);

                if (!$firstDay) {
                    $transDay = $transDayStart;
                }

                if ($transDayEnd->gt($end)) {
                    $transDayEnd = $end;
                }

                if ($transDay->lt($transDayStart)) {
                    $transDay = $transDayStart;
                }

                if ($transDay->gt($transDayEnd)) {
                    $transDay = $transDayEnd;
                }

                $diff += $transDayEnd->diffInMinutes($transDay);
            }

            $transDay->addDay();
            $startStr = $transDay->format("Ymd");
            $firstDay = false;
        }

        return $diff;
    }

    protected function parseLogs()
    {
        /** @var Collection $logs */
        $logs = $this->ticket->logs;
        $diff = 0;
        $start = $this->ticket->start_time;
        $lastStatus = Status::OPEN;

        foreach ($logs as $log) {
            if ($lastStatus == Status::OPEN) {
                $diff += $this->calculateDiff($start, $log->start_time);
            }

            $start = $log->start_time;
            $lastStatus = $log->status->type;
        }

        $now = Carbon::now();
        
        $lastLog = $logs->last();
        if ($lastLog->status->isOpen()) {
            $diff += $this->calculateDiff($lastLog->start_time, $now);
        }

        return $diff;
    }
}
