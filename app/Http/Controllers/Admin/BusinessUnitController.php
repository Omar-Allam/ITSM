<?php

namespace App\Http\Controllers\Admin;

use App\BusinessUnit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusinessUnitController extends Controller
{
    protected $rules = ['name' => 'required|unique:business_units,name', 'location' => 'required|exists:locations'];

    public function index()
    {
        $businessUnits = BusinessUnit::paginate();

        return view('admin.business_unit.index', compact('businessUnits'));
    }

    public function create()
    {
        return view('admin.business_unit.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save businessUnit');

        BusinessUnit::create($request->all());

        flash('BusinessUnit has been saved', 'success');

        return \Redirect::action('business_unit.index');
    }

    public function show(BusinessUnit $businessUnit)
    {
        return view('admin.business_unit.show', compact('businessUnit'));
    }

    public function edit(BusinessUnit $businessUnit)
    {
        return view('admin.business_unit.edit', compact('businessUnit'));
    }

    public function update(BusinessUnit $businessUnit, Request $request)
    {
        $this->validates($request, 'Could not save businessUnit');

        $businessUnit->update($request->all());

        flash('BusinessUnit has been saved', 'success');

        return \Redirect::action('business_unit.index');
    }

    public function destroy(BusinessUnit $businessUnit)
    {
        $businessUnit->delete();

        flash('BusinessUnit has been deleted', 'success');

        return \Redirect::action('business_unit.index');
    }
}
