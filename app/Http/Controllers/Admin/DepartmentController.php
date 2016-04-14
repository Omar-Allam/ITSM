<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $rules = ['name' => 'required', 'business_unit_id' => 'required|exists:business_units'];

    public function index()
    {
        $departments = Department::paginate();

        return view('admin.department.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.department.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save department');

        Department::create($request->all());

        flash('Department has been saved', 'success');

        return \Redirect::action('department.index');
    }

    public function show(Department $department)
    {
        return view('admin.department.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('admin.department.edit', compact('department'));
    }

    public function update(Department $department, Request $request)
    {
        $this->validates($request, 'Could not save department');

        $department->update($request->all());

        flash('Department has been saved', 'success');

        return \Redirect::action('department.index');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        flash('Department has been deleted', 'success');

        return \Redirect::action('department.index');
    }
}
