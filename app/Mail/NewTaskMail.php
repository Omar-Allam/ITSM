<?php

namespace App\Mail;

use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTaskMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;

    public function __construct(Ticket $task)
    {
        $this->task = $task;
    }


    public function build()
    {
        return $this->view('emails.ticket.task_assigned', ['task' => $this->task])
            ->to($this->task->technician->email)
            ->subject('A new Task #' . $this->task->id . ' On Ticket #'.$this->task->ticket->id.' has been Assigned to you');
    }
}
