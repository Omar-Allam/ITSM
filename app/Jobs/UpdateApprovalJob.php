<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\TicketApproval;
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
        
    }
}
