<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create(['name'=>'English']);
        Language::create(['name'=>'Arabic']);
        Language::create(['name'=>'Urdu']);
    }
}
