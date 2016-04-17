<?php

namespace App\Http\Controllers\Admin;

use App\BusinessUnit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusinessUnitController extends Controller
{
    protected $rules = ['name' => 'required|unique:business_units,name', 'location_id' => 'required|exists:locations,id'];

    public function index()
    {
        $businessUnits = BusinessUnit::paginate();

        return view('admin.business-unit.index', compact('businessUnits'));
    }

    public function create()
    {
        return view('admin.business-unit.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save business unit');

        BusinessUnit::create($request->all());

        flash('Business unit has been saved', 'success');

        return \Redirect::route('admin.business-unit.index');
    }

    public function show(BusinessUnit $businessUnit)
    {
        return view('admin.business-unit.show', compact('businessUnit'));
    }

    public function edit(BusinessUnit $businessUnit)
    {
        return view('admin.business-unit.edit', compact('businessUnit'));
    }

    public function update(BusinessUnit $businessUnit, Request $request)
    {
        $this->rules['name'] .= ',' . $businessUnit->id;
        $this->validates($request, 'Could not save business unit');

        $businessUnit->update($request->all());

        flash('Business unit has been saved', 'success');

        return \Redirect::route('admin.business-unit.index');
    }

    public function destroy(BusinessUnit $businessUnit)
    {
        $businessUnit->delete();

        flash('BusinessUnit has been deleted', 'success');

        return \Redirect::action('admin.business-unit.index');
    }
}
