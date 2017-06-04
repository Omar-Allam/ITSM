<?php

namespace App\Console\Commands;

use App\Jobs\CalculateTicketTime;
use App\Ticket;
use Illuminate\Console\Command;

class CalculateOpenRequestsTime extends Command
{
    protected $signature = 'tickets:calculate-time';
    protected $description = 'Calculate elapsed time for open request';


    public function handle()
    {
        Ticket::pending()->get()->each(function(Ticket $ticket) {
            dispatch(new CalculateTicketTime($ticket));
        });
    }
}
