<?php

namespace App\Reports;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class LotByCategorySummaryReport extends LotByTechnicianDetailsReport
{
    protected $view = 'reports.lot_summary_by_category';

    protected $row = 1;

    protected function fields()
    {
        $workStart = Carbon::parse(config('worktime.start'));
        $workEnd = Carbon::parse(config('worktime.end'));
        $workHours = $workEnd->diffInHours($workStart);

        $this->query->selectRaw("cat.name as category, subcat.name as subcategory");
        $this->query->selectRaw("AVG((sla.due_days * $workHours) + sla.due_hours + (sla.due_minutes / 60)) as target_time");
        $this->query->selectRaw('AVG(t.time_spent / 60) as resolve_time');
        $this->query->selectRaw("AVG((t.time_spent / 60) /((sla.due_days * $workHours) + sla.due_hours + (sla.due_minutes / 60))) as lot");
        $this->query->selectRaw("(cat.service_request OR subcat.service_request) as service_request");
    }

    protected function sort()
    {
        $this->query->orderBy('cat.name')
            ->orderBy('subcat.name')
            ->orderBy('t.id');
    }

    protected function group()
    {
        $this->query->groupBy(['cat.name', 'subcat.name']);
    }

    protected function process(Collection $data)
    {
        return $data->map(function ($ticket) {
            if ($ticket->lot < 1) {
                $ticket->performance = 100;
            } elseif ($ticket->lot < 1.3) {
                $ticket->performance = 70;
            } elseif ($ticket->lot < 1.7) {
                $ticket->performance = 30;
            } else {
                $ticket->performance = 0;
            }

            return $ticket;
        });
    }

    function html()
    {
        $data = $this->process($this->query->get());

        return view('reports.lot_summary_by_category', ['data' => $data, 'report' => $this->report]);
    }

    function excel()
    {
        $data = $this->process($this->query->get());

        return \Excel::create('lot_summary_by_category', function($excel) use ($data) {
            $excel->sheet('LOT By Category', function ($sheet) use ($data) {
                $sheet->row($this->row, ['Category', 'Subcategory', 'Target Time', "Resolve Time", 'Performance']);

                $data->each(function($ticket) use ($sheet) {
                    $sheet->row(++$this->row, [$ticket->category, $ticket->subcategory, $ticket->target_time, $ticket->resolve_time, $ticket->performance / 100]);
                });

                $sheet->setColumnFormat(["C2:D{$this->row}" => '#,##0.00']);
                $sheet->setColumnFormat(["E2:E{$this->row}" => '0.00%']);

                $sheet->setAutoFilter();
                $sheet->setAutoSize(true);
            });

            $excel->download('xlsx');
        });
    }
}