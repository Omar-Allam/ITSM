<?php

namespace App\Providers;

use App\Jobs\ApplyBusinessRules;
use App\Jobs\ApplySLA;
use App\Ticket;
use App\TicketApproval;
use Illuminate\Support\ServiceProvider;

class TicketEventsProvider extends ServiceProvider
{

    public function boot()
    {
        Ticket::created(function (Ticket $ticket) {
            dispatch(new ApplyBusinessRules($ticket));
            dispatch(new ApplySLA($ticket));
        });

        Ticket::updated(function (Ticket $ticket) {
            dispatch(new ApplySLA($ticket));
        });

        TicketApproval::created(function (TicketApproval $approval){
            $approval->ticket->status_id = 6;
            $approval->ticket->save();
        });

        TicketApproval::updated(function (TicketApproval $approval){
            if (!$approval->ticket->hasPendingApprovals()) {
                $approval->ticket->status_id = 3;
                $approval->ticket->save();
            }
        });
    }


    public function register()
    {
    }
}
