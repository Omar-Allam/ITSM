<?php

namespace App\Reports;


use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class StatsByTechnicianReport extends StatsByCategoryReport
{
    /** @var Builder */
    protected $query;

    /** @var int */
    protected $row = 1;

    /** @var string */
    protected $view = 'reports.stats_by_technician';


    protected function select()
    {
        $this->query->join('users as tech', 't.technician_id', '=', 'tech.id')
            ->selectRaw('tech.name as technician');
    }

    protected function sort()
    {
        $this->query->orderBy('tech.name');
    }

    protected function group()
    {
        $this->query->groupBy(['tech.name']);
    }


    function excel()
    {
        $data = $this->query->get();

        return \Excel::create('lot_summary_by_category', function($excel) use ($data) {
            $excel->sheet('Summary By Technician', function ($sheet) use ($data) {
                $sheet->row($this->row, [
                    'Technician', 'Requests Count', "Resolved Count",
                    'Resolved on time', 'Late', 'Very Late', 'Critical Late', 'Open', 'On Hold', 'Performance'
                ]);

                $data->each(function($ticket) use ($sheet) {
                    $sheet->row(++$this->row, [
                        $ticket->technician, $ticket->total, $ticket->total_resolved, $ticket->ontime,
                        $ticket->late, $ticket->very_late, $ticket->critical_late, $ticket->open, $ticket->onhold,
                        $ticket->performance / 100
                    ]);
                });

                $sheet->setColumnFormat(["C2:I{$this->row}" => '#,##0']);
                $sheet->setColumnFormat(["J2:J{$this->row}" => '0.00%']);

                $sheet->setAutoFilter();
                $sheet->setAutoSize(true);
            });

            $excel->download('xlsx');
        });
    }

    function pdf()
    {
        // TODO: Implement pdf() method.
    }

    function csv()
    {
        // TODO: Implement csv() method.
    }
}