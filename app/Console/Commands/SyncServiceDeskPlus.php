<?php

namespace App\Console\Commands;

use App\Helpers\ServiceDeskApi;
use Illuminate\Console\Command;

class SyncServiceDeskPlus extends Command
{
    protected $signature = 'sdp:sync';

    protected $description = 'Sync with Manage Engine ServiceDesk Plus';

    /**
     * @var ServiceDeskApi
     */
    protected $api;

    public function __construct(ServiceDeskApi $api)
    {
        parent::__construct();
        $this->api = $api;
    }

    public function handle()
    {
        $requests = $this->api->getRequests();

        $ids = array_map('intval', array_pluck($requests, 'workorderid'));
        foreach ($ids as $id) {
            $request = $this->api->getRequest($id);

        }
    }
}
