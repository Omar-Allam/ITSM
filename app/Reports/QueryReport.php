<?php

namespace App\Reports;

use Illuminate\Pagination\LengthAwarePaginator;

class QueryReport extends ReportContract
{
    function run()
    {
        if (empty($parameters['query'])) {
            throw new \HttpInvalidParamException('Cannot find queries to execute');
        }

        $query = $this->parameters['query'];
        $params = $this->parameters['params'];

        $this->data = collect(\DB::select($query, $params));
    }

    function html()
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $items = $this->data->forPage($page, $this->perPage);

        $pager = new LengthAwarePaginator($items, $this->data->count(), $this->perPage);

        return view('reports.query-report', ['items' => $pager]);
    }

    function excel()
    {

    }

    function pdf()
    {

    }

    function csv()
    {

    }
}