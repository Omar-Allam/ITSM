<?php

namespace App\Console\Commands;

use App\Attachment;
use App\Helpers\ServiceDeskApi;
use App\Jobs\SyncSDPRequest;
use App\Ticket;
use Illuminate\Console\Command;

class SyncServiceDeskPlus extends Command
{
    protected $signature = 'sdp:sync';

    protected $description = 'Sync with Manage Engine ServiceDesk Plus';

    /**
     * @var ServiceDeskApi
     */
    protected $api;

    protected $statusMap = [
        'Open' => 1,
        'Onhold' => 4
    ];

    protected $webClient = null;

    public function __construct(ServiceDeskApi $api)
    {
        parent::__construct();
        $this->api = $api;
    }

    public function handle()
    {
        $this->getNewTicketFromSDP();
    }

    protected function getNewTicketFromSDP()
    {
        Ticket::unguard();
        Attachment::flushEventListeners();

        $requests = $this->api->getRequests();
        $ids = array_map('intval', array_pluck($requests, 'workorderid'));

        foreach ($ids as $id) {
            $job = new SyncSDPRequest($id);
            $job->onQueue('sync-sdp');
            dispatch($job);
        }
    }
}
