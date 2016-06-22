<?php

use App\Impact;
use App\Priority;
use App\Status;
use App\Urgency;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    public function run()
    {
        $this->seedStatus();
        $this->seedImpact();
        $this->seedPriority();
        $this->seedUrgency();
    }

    private function seedStatus()
    {
        Status::create(['name' => 'Open', 'type' => Status::OPEN]);
        Status::create(['name' => 'Assigned', 'type' => Status::OPEN]);
        Status::create(['name' => 'In progress', 'type' => Status::OPEN]);
        Status::create(['name' => 'On Hold', 'type' => Status::PENDING]);
        Status::create(['name' => 'Awaiting Customer Response', 'type' => Status::PENDING]);
        Status::create(['name' => 'Waiting for Approval', 'type' => Status::PENDING]);
        Status::create(['name' => 'Resolved', 'type' => Status::COMPLETE]);
        Status::create(['name' => 'Closed', 'type' => Status::COMPLETE]);
    }

    private function seedImpact()
    {
        Impact::create(['name' => 'Very High']);
        Impact::create(['name' => 'High']);
        Impact::create(['name' => 'Medium']);
        Impact::create(['name' => 'Normal']);
        Impact::create(['name' => 'Low']);
    }

    private function seedPriority()
    {
        Urgency::create(['name' => 'Very High']);
        Urgency::create(['name' => 'High']);
        Urgency::create(['name' => 'Medium']);
        Urgency::create(['name' => 'Normal']);
        Urgency::create(['name' => 'Low']);
    }

    private function seedUrgency()
    {
        Priority::create(['name' => 'Immediately']);
        Priority::create(['name' => 'As soon as possible']);
        Priority::create(['name' => 'Soon enough']);
        Priority::create(['name' => 'When possible']);
        Priority::create(['name' => 'Low priority']);
    }

}
