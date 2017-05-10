<?php

namespace App\Http\Controllers;

use App\Reports\TicketReport;
use Illuminate\Http\Request;

use App\Http\Requests;

class ReportController extends Controller
{
    function index()
    {
        $fields = $this->getFields();

        return view('report.index', compact('fields'));
    }


    function show(Request $request)
    {
        $session = $request->session();

        if ($request->isMethod('post')) {
            $this->validate($request, ['fields' => 'required']);

            $fields = $request->get('fields');
            $filters = $request->get('filters');
            $session->put('ticket-report', compact('fields', 'filters'));
        } else {
            $fields = $session->get('ticket-report.fields');
            $filters = $session->get('ticket-report.filters');
        }

        $report = new TicketReport();
        $results = $report->select($fields)->filter($filters)->get();

        $fieldLabels = $this->getFields();

        return view('report.show', compact('results', 'fields', 'fieldLabels'));
    }

    protected function getFields()
    {
        return $fields = [
            'id' => 'Ticket ID',
            'technician' => 'Technician',
            'requester' => 'Requester',
            'business_unit' => 'Business Unit',
            'created_at' => 'Created at',
            'due_date' => 'Due Date',
            'resolve_date' => 'Resolve Date',
            'status' => 'Status',
            'location' => 'Location',
            'subject' => 'Subject',
            'category' => 'Category',
            'subcategory' => 'Subcategory',
            'item' => 'Item'
        ];
    }
}
