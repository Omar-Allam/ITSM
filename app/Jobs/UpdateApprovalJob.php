<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\TicketApproval;
use Illuminate\Mail\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateApprovalJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;


    /**
     * @var TicketApproval
     */
    private $ticketApproval;

    public function __construct(TicketApproval $ticketApproval)
    {
        $this->ticketApproval = $ticketApproval;
    }

    public function handle()
    {
//        $name = $this->ticketApproval->ticket->technician->name;

//        $link = link_to_route('approval.show', null, $this->ticketApproval);

//        $content = str_replace(['$approver', '$approvalLink'], [$name, $link], $this->approval->content);

        \Mail::send('emails.ticket.approval-status', ['ticketApproval' => $this->ticketApproval], function(Message $msg) {
            $msg->to([$this->ticketApproval->ticket->technician->email,$this->ticketApproval->ticket->requester->email]);
            $msg->subject('Approval Action for request #' . $this->ticketApproval->ticket->id);
        });
    }
}
