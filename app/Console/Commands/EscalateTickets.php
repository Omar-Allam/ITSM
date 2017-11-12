<?php

namespace App\Console\Commands;

use App\Jobs\EscalationJob;
use App\Ticket;
use Illuminate\Console\Command;

class EscalateTickets extends Command
{

    protected $signature = 'escalate:tickets';

    protected $description = 'Escalate Overdue Tickets';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $tickets = Ticket::whereIn('status_id', [1, 2, 3])->get();

        foreach ($tickets as $ticket) {
            $job = new EscalationJob($ticket);
            $job->onQueue('escalate-tickets');
            dispatch($job);
        }
    }
}
