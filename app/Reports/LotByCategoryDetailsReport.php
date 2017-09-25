<?php

namespace App\Reports;

use Illuminate\Support\Collection;

class LotByCategoryDetailsReport extends LotByTechnicianDetailsReport
{
    protected $view = 'reports.lot_by_category';

    protected function sort()
    {
        $this->query->orderBy('cat.name')->orderBy('t.id');
    }
}