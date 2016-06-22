<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\TicketApproval;
use Illuminate\Mail\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendApproval extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var TicketApproval
     */
    private $approval;

    public function __construct(TicketApproval $approval)
    {
        $this->approval = $approval;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->approval->approver->name;
        $link = link_to_route('approval.show', null, $this->approval);

        $content = str_replace(['$approver', '$approvalLink'], [$name, $link], $this->approval->content);

        \Mail::send('emails.ticket.approval-request', ['approval' => $this->approval, 'content' => $content], function(Message $msg) {
            $msg->to($this->approval->approver->email);
            $msg->subject('Approval required for request #' . $this->approval->ticket_id);
        });
    }
}
