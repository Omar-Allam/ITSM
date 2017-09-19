<?php

namespace App\Http\Controllers;

use App\CoreReport;
use App\Report;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    function index()
    {
        $filters = session('report-index.filters', []);

        $reports = Report::filter($filters)->paginate();

        $core_reports = CoreReport::orderBy('name')->get();

        return view('reports.index', compact('reports', 'core_reports'));
    }

    function create()
    {
        $core_reports = CoreReport::orderBy('name')->get();

        return view('reports.create', compact('core_reports'));
    }

    function store(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'core_report_id' => 'required']);

        Report::create($request->all());

        flash('Report has been saved', 'success');

        return redirect('reports.index');
    }

    function show(Report $report)
    {
        $core_report_class = $report->core_report->class_name;

        $r = new $core_report_class($report);

        if (request()->exists('excel')) {
            return $r->excel();
        }

        return $r->html();
    }

    function edit()
    {

    }

    function update()
    {

    }

    function delete()
    {

    }
}
