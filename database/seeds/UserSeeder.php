<?php

use App\Group;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * @var Group
     */
    protected $adminGroup;

    /**
     * @var Group
     */
    protected $usersGroup;

    public function run()
    {
        $this->seedGroups();
        $this->seedUsers();
    }

    private function seedGroups()
    {
        $this->adminGroup = Group::create(['name' => 'Administrators', 'type' => Group::ADMIN]);
        $this->usersGroup = Group::create(['name' => 'All Users', 'type' => Group::REQUESTER]);
        Group::create(['name' => 'Dammam Support', 'type' => Group::TECHNICIAN]);
        Group::create(['name' => 'Al-Ahsaa Support', 'type' => Group::TECHNICIAN]);
        Group::create(['name' => 'Hubtech CRM', 'type' => Group::COORDINATOR]);
        Group::create(['name' => 'Service Desk', 'type' => Group::COORDINATOR]);
    }

    private function seedUsers()
    {
        $this->adminGroup->users()->attach(User::create([
            'name' => 'Administrator',
            'email' => 'administrator@alkifah.com',
            'login' => 'admin',
            'password' => bcrypt('Kifah1234'),
            'location_id' => 2,
            'business_unit_id' => 2,
            'vip' => false,
            'is_ad' => false,
        ]));

        for ($i = 0; $i < 30; ++$i) {
            $user = factory(User::class)->create();
            $this->usersGroup->users()->attach($user);
        }

    }
}
