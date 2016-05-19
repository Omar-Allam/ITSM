<?php

namespace App\Providers;

use App\Jobs\ApplyBusinessRules;
use App\Jobs\ApplySLA;
use App\Ticket;
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
    }


    public function register()
    {
    }
}
