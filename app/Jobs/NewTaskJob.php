<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Message;
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
      $this->ticket = $ticket;
      $this->task = $task;
    }


    public function handle()
    {
        \Mail::send('emails.ticket.task_assigned', ['ticket' => $this->ticket , 'task'=>$this->task], function(Message $msg) {
            $ticket = $this->ticket;
            $task = $this->task;
            $msg->subject('A new Task #' . $task->id . ' in Ticket #'.$ticket->id.' has been Assigned to you');
            $msg->to($task->technician->email);
        });
    }
}