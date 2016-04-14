<?php

namespace App\Http\Controllers\Admin;

use App\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    protected $rules = ['name' => 'required|unique:regions,name'];

    public function index()
    {
        $regions = Region::paginate();

        return view('admin.region.index', compact('regions'));
    }

    public function create()
    {
        return view('admin.region.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save region');

        Region::create($request->all());

        flash('Region has been saved', 'success');

        return \Redirect::route('admin.region.index');
    }

    public function show(Region $region)
    {
        return view('admin.region.show', compact('region'));
    }

    public function edit(Region $region)
    {
        return view('admin.region.edit', compact('region'));
    }

    public function update(Region $region, Request $request)
    {
        $this->validates($request, 'Could not save region');

        $region->update($request->all());

        flash('Region has been saved', 'success');

        return \Redirect::route('admin.region.index');
    }

    public function destroy(Region $region)
    {
        $region->delete();

        flash('Region has been deleted', 'success');

        return \Redirect::route('admin.region.index');
    }
    
}
