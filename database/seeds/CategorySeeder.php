<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    protected $cats = [];

    protected $emis = [];

    public function run()
    {
        $this->seedCategories();
        $this->seedSubcategories();
        $this->seedItems();
    }

    private function seedCategories()
    {
        $this->cats['attendance'] = Category::create(['name' => 'Attendance Terminal']);
        $this->cats['callcenter'] = Category::create(['name' => 'Call center']);
        $this->cats['computers'] = Category::create(['name' => 'Computers (Desktop/Laptop)']);
        $this->cats['email'] = Category::create(['name' => 'Email']);
        $this->cats['helpdesk'] = Category::create(['name' => 'Helpdesk']);
        $this->cats['emis'] = Category::create(['name' => 'EMIS Application']);
        $this->cats['internet'] = Category::create(['name' => 'Internet']);
        $this->cats['ip-phone'] = Category::create(['name' => 'IP Telephone']);
        $this->cats['kastle'] = Category::create(['name' => 'Kastle']);
        $this->cats['mobile'] = Category::create(['name' => 'Mobile/SIM Services']);
        $this->cats['network'] = Category::create(['name' => 'Network']);
        $this->cats['hardware'] = Category::create(['name' => 'New IT Hardware']);
        $this->cats['printer'] = Category::create(['name' => 'Printer / Copier']);
        $this->cats['camera'] = Category::create(['name' => 'Surveillance Cameras']);
        $this->cats['web'] = Category::create(['name' => 'Web Development']);
    }

    private function seedSubcategories()
    {
        $this->cats['callcenter']->subcategories()->create(['name' => 'Troubleshoot']);
        $this->cats['callcenter']->subcategories()->create(['name' => 'New Request']);

        $this->cats['attendance']->subcategories()->create(['name' => 'Device Installation']);
        $this->cats['attendance']->subcategories()->create(['name' => 'Troubleshoot']);
        $this->cats['attendance']->subcategories()->create(['name' => 'Grant/Revoke Permissions']);
        $this->cats['attendance']->subcategories()->create(['name' => 'Move employee fingerprint']);

        $this->cats['computers']->subcategories()->create(['name' => 'Troubleshoot']);
        $this->cats['computers']->subcategories()->create(['name' => 'Migrate old data']);
        $this->cats['computers']->subcategories()->create(['name' => 'Move desktop location']);
        $this->cats['computers']->subcategories()->create(['name' => 'Install new software']);
        $this->cats['computers']->subcategories()->create(['name' => 'Configure user account']);

        $this->cats['email']->subcategories()->create(['name' => 'Unable to login']);
        $this->cats['email']->subcategories()->create(['name' => 'Create user account']);
        $this->cats['email']->subcategories()->create(['name' => 'Create group account']);

        $this->emis['troubleshoot'] = $this->cats['emis']->subcategories()->create(['name' => 'Troubleshoot']);
        $this->emis['new'] = $this->cats['emis']->subcategories()->create(['name' => 'New Request']);
        $this->emis['admin'] = $this->cats['emis']->subcategories()->create(['name' => 'EMIS Administration']);

        $this->cats['helpdesk']->subcategories()->create(['name' => 'New Report']);
        $this->cats['helpdesk']->subcategories()->create(['name' => 'Modify Report']);
        $this->cats['helpdesk']->subcategories()->create(['name' => 'Unable to login']);
        $this->cats['helpdesk']->subcategories()->create(['name' => 'Add User']);
    }

    private function seedItems()
    {
        $modules = ['APM', 'ARM', 'BFM', 'CSH', 'FAM', 'FSM', 'GLM', 'ICM', 'POM', 'PPM', "SOM"];

        foreach ($modules as $module) {
            $this->emis['troubleshoot']->items()->create(['name' => $module]);
            $this->emis['new']->items()->create(['name' => $module]);
        }

        $this->emis['admin']->items()->create(['name' => 'Create user']);
        $this->emis['admin']->items()->create(['name' => 'Grant/Revoke permissions']);
    }


}
