<?php

namespace App\Http\Controllers\Admin;

use App\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    protected $rules = ['name' => 'required', 'location_id' => 'required|exists:locations,id', 'business_unit_id' => 'required|exists:business_units,id'];

    public function index()
    {
        $branches = Branch::paginate();

        return view('admin.branch.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branch.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save branch');

        Branch::create($request->all());

        flash('Branch has been saved', 'success');

        return \Redirect::action('branch.index');
    }

    public function show(Branch $branch)
    {
        return view('admin.branch.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        return view('admin.branch.edit', compact('branch'));
    }

    public function update(Branch $branch, Request $request)
    {
        $this->validates($request, 'Could not save branch');

        $branch->update($request->all());

        flash('Branch has been saved', 'success');

        return \Redirect::action('branch.index');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        flash('Branch has been deleted', 'success');

        return \Redirect::action('branch.index');
    }
}
