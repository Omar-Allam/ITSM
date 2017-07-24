<?php

namespace App\Console\Commands;
use App\Helpers\ServiceDeskApi;
use Illuminate\Console\Command;

class SyncByRequest extends Command
{

    protected $signature = 'sdp:getRequest';

    protected $description = 'Get Specific Request By Name';


    protected $syncrequest;
    public function __construct(ServiceDeskApi $api)
    {
        parent::__construct();
        $this->syncrequest= new SyncServiceDeskPlus($api);
    }

    public function handle()
    {
        $id = $this->ask('Enter request Name');
        $this->syncrequest->getRequestById($id);
    }


}
