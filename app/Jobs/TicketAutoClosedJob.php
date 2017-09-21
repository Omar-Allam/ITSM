<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Ticket;
use Illuminate\Mail\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketAutoClosedJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function handle()
    {
        if (!$this->ticket->sdp_id) {
            \Mail::send('emails.ticket.autoclose', ['ticket' => $this->ticket], function (Message $msg) {
                $msg->to($this->ticket->requester->email);
                $msg->subject('Your ticket [#' . $this->ticket->id . '#] has been closed automatically');
            });
        }
    }
}
