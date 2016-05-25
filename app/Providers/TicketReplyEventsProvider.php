<?php

namespace App\Providers;

use App\TicketLog;
use App\TicketReply;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class TicketReplyEventsProvider extends ServiceProvider
{
    public function boot()
    {
        TicketReply::creating(function (TicketReply $reply) {
            if (!$reply->status_id) {
                $reply->status_id = $reply->ticket->status_id;
            } else {
                $reply->ticket->status_id = $reply->status_id;
                if ($reply->status_id == 7) {
                    $reply->ticket->resolve_date = Carbon::now();
                }
            }
            
            TicketLog::addReply($reply);
            $reply->ticket->save();
        });
    }

    public function register()
    {
        //
    }
}
