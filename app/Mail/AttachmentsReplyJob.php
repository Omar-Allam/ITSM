<?php

namespace App\Mail;

use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AttachmentsReplyJob extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $attachs;
    public function __construct($attachments)
    {
        $this->attachs = $attachments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ticket = Ticket::find($this->attachs->first()->ticket_id);
        $subject = 'Re: Ticket #' . $ticket->id . ' ' . $ticket->subject;
        if ($ticket->sdp_id) {
            $subject .= " [Request ##{$ticket->sdp_id}##]";
        }

        return $this->to([$ticket->requester->email])
            ->subject($subject)
            ->markdown('emails.reply.attachments')->with(['attachs'=>$this->attachs,'ticket'=>$ticket]);
    }
}
