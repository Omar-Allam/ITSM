<?php

use App\City;
use App\Location;
use App\Region;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    protected $regions = [];

    protected $cities = [];

    protected $locations = [];

    public function run()
    {
        $this->addRegions();
        $this->addCities();
        $this->addLocations();
    }

    private function addRegions()
    {
        $this->regions['eastern'] = Region::create(['name' => 'Eastern']);
        $this->regions['riyadh'] = Region::create(['name' => 'Riyadh']);
        $this->regions['jeddah'] = Region::create(['name' => 'Jeddah']);
        $this->regions['madinah'] = Region::create(['name' => 'Madinah']);
    }

    private function addCities()
    {
        $this->cities['dammam'] = $this->regions['eastern']->cities()->create(['name' => 'Dammam']);
        $this->cities['khubar'] = $this->regions['eastern']->cities()->create(['name' => 'Khubar']);
        $this->cities['jubail'] = $this->regions['eastern']->cities()->create(['name' => 'Jubail']);
        $this->cities['ahsaa'] = $this->regions['eastern']->cities()->create(['name' => 'Al-Ahsaa']);

        $this->cities['riyadh'] = $this->regions['riyadh']->cities()->create(['name' => 'Riyadh']);
        $this->cities['hail'] = $this->regions['riyadh']->cities()->create(['name' => 'Hail']);

        $this->cities['jeddah'] = $this->regions['jeddah']->cities()->create(['name' => 'Jeddah']);
        $this->cities['madinah'] = $this->regions['madinah']->cities()->create(['name' => 'Madinah']);
    }

    private function addLocations()
    {
        $this->cities['dammam']->locations()->create(['name' => 'Kifah Tower']);
        $this->cities['khubar']->locations()->create(['name' => 'Kifah Plaza']);

        $this->cities['ahsaa']->locations()->create(['name' => 'Head office']);

        $this->cities['jeddah']->locations()->create(['name' => 'Jeddah Readymix Factory']);
    }
}
