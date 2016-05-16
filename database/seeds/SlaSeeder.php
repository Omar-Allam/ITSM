<?php

use Illuminate\Database\Seeder;

class SlaSeeder extends Seeder
{
    public function run()
    {
        $sla = App\Sla::create([
            'name' => 'Helpdesk SLA', 'due_days' => 1, 'due_hours' => 0, 'due_minutes' => 0,
            'response_days' => 0, 'response_hours' => 4, 'response_minutes' => 0,
            'critical' => false
        ]);

        $category = App\Category::where('name', 'Helpdesk')->first();

        $sla->updateCriteria([[
            'operator' => 'is',
            'field' => 'category_id',
            'label' => $category->name,
            'value' => $category->id
        ]]);
    }
}
