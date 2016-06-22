<?php

namespace App\Providers;

use App\Attachment;
use App\Jobs\ApplyBusinessRules;
use App\Jobs\ApplySLA;
use App\Jobs\CalculateTicketTime;
use App\Ticket;
use App\TicketApproval;
use App\TicketLog;
use Illuminate\Support\ServiceProvider;

class TicketEventsProvider extends ServiceProvider
{

    public function boot()
    {
        Ticket::created(function (Ticket $ticket) {
            dispatch(new ApplyBusinessRules($ticket));
            dispatch(new ApplySLA($ticket));

            Attachment::uploadFiles(Attachment::TICKET_TYPE, $ticket->id);
        });

        Ticket::updated(function (Ticket $ticket) {
            dispatch(new ApplySLA($ticket));
            dispatch(new CalculateTicketTime($ticket));
        });
        
        Ticket::updating(function (Ticket $ticket) {
            if (!$ticket->stopLog()) {
                TicketLog::addUpdating($ticket);
            }
        });

        TicketApproval::created(function (TicketApproval $approval){
            $approval->ticket->status_id = 6;
            TicketLog::addApproval($approval);
            $approval->ticket->save();
        });

        TicketApproval::updated(function (TicketApproval $approval){
            if (!$approval->ticket->hasPendingApprovals()) {
                $approval->ticket->status_id = 3;
                TicketLog::addApprovalUpdate($approval, $approval->status == TicketApproval::APPROVED);
                $approval->ticket->save();
            }
        });
    }


    public function register()
    {
    }
}
