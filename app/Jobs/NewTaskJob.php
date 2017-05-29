<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NewTaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ticket;
    private $task;
    public function __construct($task,$ticket)
    {
        \Mail::send('emails.ticket.task-assigned', ['ticket' => $this->ticket], function(Message $msg) {
            $ticket = $this->ticket;
            $msg->subject('A new ticket #' . $ticket->id . ' has been created for you');
            $msg->to($ticket->requester->email);
        });
    }


    public function handle()
    {

    }
}
