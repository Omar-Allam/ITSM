<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NewNoteJob implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $note;
    public function __construct($note)
    {
        $this->note = $note;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::send('emails.ticket.new-note', ['note' => $this->note], function(Message $msg) {
            $note = $this->note;
            $msg->subject('Your assigned ticket #' . $note->ticket_id.' updated with a new note');
            $msg->to($note->ticket->technician->email);
        });
    }
}
