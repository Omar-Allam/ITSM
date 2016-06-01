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

    public function show(BusinessUnit $business_unit)
    {
        return view('admin.business-unit.show', compact('business_unit'));
    }

    public function edit(BusinessUnit $business_unit)
    {
        return view('admin.business-unit.edit', compact('business_unit'));
    }

    public function update(BusinessUnit $business_unit, Request $request)
    {
        $this->rules['name'] .= ',' . $business_unit->id;
        $this->validates($request, 'Could not save business unit');

        $business_unit->update($request->all());

        flash('Business unit has been saved', 'success');

        return \Redirect::route('admin.business-unit.index');
    }

    public function destroy(BusinessUnit $business_unit)
    {
        $business_unit->delete();

        flash('BusinessUnit has been deleted', 'success');

        return \Redirect::action('admin.business-unit.index');
    }
}
