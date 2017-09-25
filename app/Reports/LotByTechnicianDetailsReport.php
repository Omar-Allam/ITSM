<?php

namespace App\Reports;

use App\Status;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class LotByTechnicianDetailsReport extends ReportContract
{
    /** @var Builder */
    protected $query;

    protected $view = 'reports.lot_by_technician';

    function run()
    {
        if (empty($this->parameters['start_date'])) {
            throw new \InvalidArgumentException('Could not found required parameter start_date');
        }

        $this->query = Ticket::withoutGlobalScopes()->with('sla')->from('tickets as t')
            ->join('users as tech', 't.technician_id', '=', 'tech.id')
            ->join('users as req', 't.requester_id', '=', 'req.id')
            ->join('statuses as st', 't.status_id', '=', 'st.id')
            ->join('categories as cat', 't.category_id', '=', 'cat.id')
            ->leftJoin('subcategories as subcat', 't.subcategory_id', '=', 'subcat.id')
            ->leftJoin('items as item', 't.item_id', '=', 'item.id')
            ->leftJoin('slas as sla', 't.sla_id', '=', 'sla.id')
            ->where('st.type', Status::COMPLETE);

        $this->fields();
        $this->group();
        $this->sort();

        $this->applyFilters();
    }

    protected function fields()
    {
        $this->query->selectRaw('t.id as id, t.subject, t.created_at, t.due_date, t.resolve_date, tech.name as technician, req.name as requester')
            ->selectRaw('t.sla_id, resolve_date, overdue, time_spent, t.sdp_id')
            ->selectRaw('cat.name as category, subcat.name as subcategory, item.name as item');

        $this->query->selectRaw("(cat.service_request OR subcat.service_request OR item.service_request) as service_request");  
    }

    protected function sort()
    {
        $this->query->orderBy('tech.name')->orderBy('t.id');
    }

    protected function group()
    {
    }

    protected function process(Collection $data)
    {
        $workStart = Carbon::parse(config('worktime.start'));
        $workEnd = Carbon::parse(config('worktime.end'));
        $workHours = $workEnd->diffInHours($workStart);

        return $data->map(function (Ticket $ticket) use ($workHours) {
            // calculate SLA time in hour to compare to time spent on request
            $ticket->sla_time = $ticket->sla->due_days * $workHours +
                $ticket->sla->due_hours +
                ($ticket->sla->due_minutes / 60);

            $ticket->resolve_time = $ticket->time_spent / 60;

            $factor = $ticket->resolve_time / $ticket->sla_time;

            if ($factor < 1) {
                $ticket->performance = 100;
            } elseif ($factor < 1.3) {
                $ticket->performance = 70;
            } elseif ($factor < 1.7) {
                $ticket->performance = 30;
            } else {
                $ticket->performance = 0;
            }

            $ticket->type = $ticket->service_request? t('Service') : t('Incident');

            return $ticket;
        });
    }

    function html()
    {
        $page = LengthAwarePaginator::resolveCurrentPage();

        $count = $this->query->count();

        $chunk = $this->process($this->query->forPage($page, $this->perPage)->get());

        $data = new LengthAwarePaginator($chunk, $count, $this->perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view($this->view, ['data' => $data, 'report' => $this->report]);
    }

    function excel()
    {
        \Excel::create(str_slug($this->report->title), function (LaravelExcelWriter $writer) {
            $writer->sheet('LOT By Tech', function (LaravelExcelWorksheet $sheet) {
                $this->row = 1;
                $sheet->row($this->row, [
                    'ID', 'Helpdesk ID', 'Subject', 'Technician', 'Requester', 'Category', 'Subcategory', 'Item',
                    'Created At', 'Due Date', 'Resolved At', 'SLA Time (In Hours)', 'Resolve Time (In Hours)', 'Performance', 'Type'
                ]);

                $this->process($this->query->get())->each(function ($ticket) use ($sheet) {
                    $sheet->row(++$this->row, [
                        $ticket->id, $ticket->sdp_id, $ticket->subject, $ticket->technician, $ticket->requester,
                        $ticket->category, $ticket->subcategory, $ticket->item,
                        $ticket->created_at->format('d/m/Y H:i'),
                        $ticket->due_date->format('d/m/Y H:i'),
                        $ticket->resolve_date ? $ticket->resolve_date->format('d/m/Y H:i') : '',
                        number_format($ticket->sla_time, 1),
                        number_format($ticket->resolve_time, 1),
                        number_format($ticket->performance, 1),
                        $ticket->type
                    ]);
                });

                $sheet->setAutoFilter();
                $sheet->freezeFirstRow();
            });

            $writer->download('xlsx');
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