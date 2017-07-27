<?php

namespace App\Console\Commands;

use App\Jobs\TicketAutoClosedJob;
use App\Ticket;
use App\TicketLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoCloseResolvedTickets extends Command
{
    protected $signature = 'tickets:auto-close';

    protected $description = 'Auto close resolved tickets after 3 business days';

    /**
     * @var Carbon
     */
    protected $now;


    public function __construct()
    {
        parent::__construct();
        Carbon::setWeekendDays([Carbon::FRIDAY, Carbon::SATURDAY]);
        $this->now = Carbon::now();
    }

    public function handle()
    {
        $tickets = Ticket::whereIn('status_id', [7, 9])->get();

        Ticket::flushEventListeners();
        /** @var Ticket $ticket */
        foreach ($tickets as $ticket) {
//            dump(['id' => $ticket->id, 'close' => $this->shouldClose($ticket), 'resolve' => $ticket->resolve_date->format('c')]);
            if ($this->shouldClose($ticket)) {
                $ticket->status_id = 8;
                $ticket->close_date = Carbon::now();
                $ticket->save();

                TicketLog::addAutoClose($ticket);
                dispatch(new TicketAutoClosedJob($ticket));
            }
        }
    }

    private function shouldClose(Ticket $ticket)
    {
        if (!$ticket->resolve_date) {
            $date = clone $ticket->updated_at; // for old not closed tickets
        } else {
            $date = clone $ticket->resolve_date;
        }

        for ($i = 0; $i < 3; ++$i) {
            $date->addDay();
            if ($date->isWeekend()) {
                --$i;
            }
        }

        return $this->now->gte($date);
    }
}
