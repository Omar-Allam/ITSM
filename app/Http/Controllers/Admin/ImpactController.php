<?php

namespace App\Http\Controllers\Admin;

use App\Impact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImpactController extends Controller
{

    protected $rules = ['name' => 'required'];

    public function index()
    {
        $impacts = Impact::paginate();

        return view('admin.impact.index', compact('impacts'));
    }

    public function create()
    {
        return view('admin.impact.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save impact');

        Impact::create($request->all());

        flash('Impact has been saved', 'success');

        return \Redirect::route('admin.impact.index');
    }

    public function show(Impact $impact)
    {
        return view('admin.impact.show', compact('impact'));
    }

    public function edit(Impact $impact)
    {
        return view('admin.impact.edit', compact('impact'));
    }

    public function update(Impact $impact, Request $request)
    {
        $this->validates($request, 'Could not save impact');

        $impact->update($request->all());

        flash('Impact has been saved', 'success');

        return \Redirect::route('admin.impact.index');
    }

    public function destroy(Impact $impact)
    {
        $impact->delete();

        flash('Impact has been deleted', 'success');

        return \Redirect::route('admin.impact.index');
    }
}
