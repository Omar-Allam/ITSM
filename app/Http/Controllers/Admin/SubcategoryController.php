<?php

namespace App\Http\Controllers\Admin;

use App\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoryController extends Controller
{

    protected $rules = ['name' => 'required', 'category_id' => 'required|exists:categories,id'];

    public function index()
    {
        $subcategories = Subcategory::paginate();

        return view('admin.subcategory.index', compact('subcategories'));
    }

    public function create(Request $request)
    {
        $category_id = 0;
        if ($request->has('category')) {
            $category_id = $request->get('category');
        }

        return view('admin.subcategory.create', compact('category_id'));
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save category');

        $subcategory = Subcategory::create($request->all());

        flash('Subcategory has been saved', 'success');

        return \Redirect::route('admin.category.show', $subcategory->category_id);
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

        return \Redirect::route('admin.category.show', $subcategory->category_id);
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();

        flash('Subcategory has been deleted', 'success');

        return \Redirect::route('admin.category.show', $subcategory->category_id);
    }
}
