<?php

namespace App\Providers;

use App\TicketLog;
use App\TicketNote;
use Illuminate\Support\ServiceProvider;

class TicketNoteEventProvider extends ServiceProvider
{

    public function boot()
    {
        TicketNote::creating(function (TicketNote $note){
            TicketLog::addNote($note);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
