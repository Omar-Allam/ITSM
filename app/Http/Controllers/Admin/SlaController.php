<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SlaRequest;
use App\Sla;
use App\Http\Controllers\Controller;

class SlaController extends Controller
{

    protected $rules = ['name' => 'required'];

    public function index()
    {
        $slas = Sla::paginate();

        return view('admin.sla.index', compact('slas'));
    }

    public function create()
    {
        return view('admin.sla.create');
    }

    public function store(SlaRequest $request)
    {
        Sla::create($request->all());

        flash('SLA has been saved', 'success');

        return \Redirect::route('admin.sla.index');
    }

    public function show(Sla $sla)
    {
        return view('admin.sla.show', compact('sla'));
    }

    public function edit(Sla $sla)
    {
        return view('admin.sla.edit', compact('sla'));
    }

    public function update(Sla $sla, SlaRequest $request)
    {
        $sla->update($request->all());

        flash('SLA has been saved', 'success');

        return \Redirect::route('admin.sla.index');
    }

    public function destroy(Sla $sla)
    {
        $sla->delete();

        flash('SLA has been deleted', 'success');

        return \Redirect::route('admin.sla.index');
    }
}
