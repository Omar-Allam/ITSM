<?php

namespace App\Console\Commands;
use App\Helpers\ServiceDeskApi;
use App\Jobs\SyncSDPRequest;
use Illuminate\Console\Command;

class SyncByRequest extends Command
{

    protected $signature = 'sdp:get-request {id?}';

    protected $description = 'Get specific request by ID';

    public function handle()
    {
        $id = intval($this->argument('id') ?: $this->ask('Enter request ID'));
        if (!$id) {
            $this->error('');
            return 1;
        }
        $job = new SyncSDPRequest($id);
        $job->onQueue('sync-sdp');
        dispatch($job);
    }


}
