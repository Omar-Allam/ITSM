<?php

use Illuminate\Database\Seeder;

class CoreReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now()->format('Y-m-d H:i:s');

        \DB::table('core_reports')->insert([
            ['id' => 1, 'name' => 'Query Report', 'class_name' => 'App\Reports\QueryReport', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'LOT By Technician Details', 'class_name' => 'App\Reports\LotByTechnicianDetailsReport', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'LOT By Category Details', 'class_name' => 'App\Reports\LotByCategoryDetailsReport', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'name' => 'LOT By Technician - Summary', 'class_name' => 'App\Reports\LotByTechnicianSummaryReport', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'name' => 'LOT By Category - Summary', 'class_name' => 'App\Reports\LotByCategorySummaryReport', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'name' => 'Stats by Category', 'class_name' => 'App\Reports\StatsByCategoryReport', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'name' => 'Stats by Technician', 'class_name' => 'App\Reports\StatsByTechnicianReport', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
