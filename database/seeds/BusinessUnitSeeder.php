<?php

use App\BusinessUnit;
use Illuminate\Database\Seeder;

class BusinessUnitSeeder extends Seeder
{
    public function run()
    {
        BusinessUnit::create(['name' => 'Kifah Holding', 'location_id' => 3]);
        BusinessUnit::create(['name' => 'Hubtech', 'location_id' => 2]);
        BusinessUnit::create(['name' => 'Tamweel', 'location_id' => 2]);
        BusinessUnit::create(['name' => 'Kifah Contracting', 'location_id' => 2]);
    }
}
