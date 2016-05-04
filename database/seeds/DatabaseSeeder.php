<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocationSeeder::class);
        $this->call(ConfigSeeder::class);
        $this->call(BusinessUnitSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
