<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $rules = ['name' => 'required|unique:cities', 'region_id' => 'required|exists:regions,id'];

    public function index()
    {
        $cities = City::paginate();

        return view('admin.city.index', compact('cities'));
    }

    public function create()
    {
        return view('admin.city.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save city');

        City::create($request->all());

        flash('City has been saved', 'success');

        return \Redirect::route('admin.city.index');
    }

    public function show(City $city)
    {
        return view('admin.city.show', compact('city'));
    }

    public function edit(City $city)
    {
        return view('admin.city.edit', compact('city'));
    }

    public function update(City $city, Request $request)
    {
        $this->rules['name'] .= ',name,' . $city->id;
        $this->validates($request, 'Could not save city');

        $city->update($request->all());

        flash('City has been saved', 'success');

        return \Redirect::route('admin.city.index');
    }

    public function destroy(City $city)
    {
        $city->delete();

        flash('City has been deleted', 'success');

        return \Redirect::route('admin.city.index');
    }
}
