<?php

namespace App\Reports;

class LotByCategoryDetailsReport extends LotByTechnicianDetailsReport
{
    protected $view = 'reports.lot_by_category';

    protected function fields()
    {
        parent::fields();

        $this->query->selectRaw("(cat.service_request OR subcat.service_request OR item.service_request) as service_request");
    }

    protected function sort()
    {
        $this->query->orderBy('cat.name')->orderBy('t.id');
    }
}