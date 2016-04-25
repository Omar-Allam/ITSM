<?php

namespace App\Http\Controllers\Admin;

use App\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoryController extends Controller
{

    protected $rules = [];

    public function index()
    {
        $subcategories = Subcategory::paginate();

        return view('admin.subcategory.index', compact('subcategories'));
    }

    public function create()
    {
        return view('admin.subcategory.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save category');

        Subcategory::create($request->all());

        flash('Subcategory has been saved', 'success');

        return \Redirect::route('admin.subcategory.index');
    }

    public function show(Subcategory $subcategory)
    {
        return view('admin.subcategory.show', compact('subcategory'));
    }

    public function edit(Subcategory $subcategory)
    {
        return view('admin.subcategory.edit', compact('subcategory'));
    }

    public function update(Subcategory $subcategory, Request $request)
    {
        $this->validates($request, 'Could not save category');

        $subcategory->update($request->all());

        flash('Subcategory has been saved', 'success');

        return \Redirect::route('admin.subcategory.index');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();

        flash('Subcategory has been deleted', 'success');

        return \Redirect::route('admin.subcategory.index');
    }
}
