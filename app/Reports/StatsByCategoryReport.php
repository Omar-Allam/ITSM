<?php

namespace App\Reports;


use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class StatsByCategoryReport extends ReportContract
{
    /** @var Builder */
    protected $query;

    /** @var int */
    protected $row = 1;

    /** @var string */
    protected $view = 'reports.stats_by_category';

    function run()
    {
        $workStart = Carbon::parse(config('worktime.start'));
        $workEnd = Carbon::parse(config('worktime.end'));
        $workHours = $workEnd->diffInHours($workStart);

        $this->query = \DB::table('tickets as t')
            ->join('statuses as st', 't.status_id', '=', 'st.id')
            ->join('slas as sla', 't.sla_id', '=', 'sla.id')
            ->selectRaw('COUNT(t.id) as total')
            ->selectRaw('COUNT(CASE WHEN st.type = 1 THEN 1 END) as open')
            ->selectRaw('COUNT(CASE WHEN st.type = 2 THEN 1 END) as onhold')
            ->selectRaw('COUNT(CASE WHEN st.type = 3 THEN 1 END) as total_resolved')
            ->selectRaw("COUNT(CASE WHEN st.type = 3 AND (t.time_spent / 60) /((sla.due_days * $workHours) + sla.due_hours + (sla.due_minutes / 60)) <= 1 THEN 1 END) as ontime")
            ->selectRaw("COUNT(CASE WHEN st.type = 3 AND (t.time_spent / 60) /((sla.due_days * $workHours) + sla.due_hours + (sla.due_minutes / 60)) between 1 AND 1.3 THEN 1 END) as late")
            ->selectRaw("COUNT(CASE WHEN st.type = 3 AND (t.time_spent / 60) /((sla.due_days * $workHours) + sla.due_hours + (sla.due_minutes / 60)) between 1.3 AND 1.7 THEN 1 END) as very_late")
            ->selectRaw("COUNT(CASE WHEN st.type = 3 AND (t.time_spent / 60) /((sla.due_days * $workHours) + sla.due_hours + (sla.due_minutes / 60)) > 1.7 THEN 1 END) as critical_late")
            ->selectRaw(<<<perf
AVG(
CASE 
WHEN st.type = 3 AND (t.time_spent / 60) /((sla.due_days * $workHours) + sla.due_hours + (sla.due_minutes / 60)) > 1.7 THEN 0
WHEN  st.type = 3 AND (t.time_spent / 60) /((sla.due_days * $workHours) + sla.due_hours + (sla.due_minutes / 60)) BETWEEN 1.3 AND 1.7 THEN 30
WHEN  st.type = 3 AND (t.time_spent / 60) /((sla.due_days * $workHours) + sla.due_hours + (sla.due_minutes / 60)) BETWEEN 1 AND 1.3 THEN 70
WHEN  st.type = 3 AND (t.time_spent / 60) /((sla.due_days * $workHours) + sla.due_hours + (sla.due_minutes / 60)) <= 1 THEN 100
END) as performance
perf
);

        $this->select();
        $this->sort();
        $this->group();
        $this->applyFilters();
    }

    protected function select()
    {
        $this->query->join('categories as cat', 't.category_id', '=', 'cat.id')
            ->join('subcategories as subcat', 't.subcategory_id', '=', 'subcat.id')
            ->selectRaw('cat.name as category, subcat.name as subcategory');
    }

    protected function sort()
    {
        $this->query->orderBy('cat.name')->orderBy('subcat.name');
    }

    protected function group()
    {
        $this->query->groupBy(['cat.name', 'subcat.name']);
    }

    function html()
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $total = $this->query->get()->count();
        $chunk = $this->query->forPage($page, $this->perPage)->get();

        $data = new LengthAwarePaginator($chunk, $total, $this->perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);

        return view($this->view, ['data' => $data, 'report' => $this->report]);
    }

    function excel()
    {
        $data = $this->query->get();

        return \Excel::create('lot_summary_by_category', function($excel) use ($data) {
            $excel->sheet('LOT By Category', function ($sheet) use ($data) {
                $sheet->row($this->row, [
                    'Category', 'Subcategory', 'Requests Count', "Resolved Count",
                    'Resolved on time', 'Late', 'Very Late', 'Critical Late', 'Open', 'On Hold', 'Performance'
                ]);

                $data->each(function($ticket) use ($sheet) {
                    $sheet->row(++$this->row, [
                        $ticket->category, $ticket->subcategory, $ticket->total, $ticket->total_resolved, $ticket->ontime,
                        $ticket->late, $ticket->very_late, $ticket->critical_late, $ticket->open, $ticket->onhold,
                        $ticket->performance / 100
                    ]);
                });

                $sheet->setColumnFormat(["C2:J{$this->row}" => '#,##0']);
                $sheet->setColumnFormat(["K2:K{$this->row}" => '0.00%']);

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

    protected function applyFilters()
    {
        // Show only tickets that user can show
        $user = auth()->user();
        if (!$user->isAdmin()) {
            $this->query->whereIn('t.group_id', $user->groups()->pluck('group_id'));
        }

        // Start data is required parameter
        $start_date = Carbon::parse($this->parameters['start_date']);
        $start_date->setTime(0, 0, 0);

        $this->query->where('due_date', '>=', $start_date);

        if (!empty($this->parameters['end_date'])) {
            $end_date = Carbon::parse($this->parameters['end_date']);
            $end_date->setTime(23, 59, 59);

            $this->query->where('due_date', '<=', $end_date);
        }

        if (!empty($this->parameters['technician'])) {
            if (is_array($this->parameters['technician'])) {
                $technicians = $this->parameters['technician'];
            } else {
                $technicians = array_map('trim', explode(',', $this->parameters['technician']));
            }

            $this->query->whereIn('t.technician_id', $technicians);
        }

        if (!empty($this->parameters['category'])) {
            if (is_array($this->parameters['category'])) {
                $categories = $this->parameters['category'];
            } else {
                $categories = array_map('trim', explode(',', $this->parameters['category']));
            }

            $this->query->whereIn('t.category_id', $categories);
        }

        return $this->query;
    }
}