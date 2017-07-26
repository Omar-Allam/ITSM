<?php

namespace App\Providers;

use App\ExtractImages;
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

        TicketNote::saving(function (TicketNote $note){
            $extract_image = new ExtractImages($note->note);
            $note['note'] = $extract_image->extract();
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
