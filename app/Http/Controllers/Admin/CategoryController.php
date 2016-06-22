<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    protected $rules = ['name' => 'required', 'description' => 'max:500'];

    public function index()
    {
        $categories = Category::paginate();

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save category');

        Category::create($request->all());

        flash('Category has been saved', 'success');

        return \Redirect::route('admin.category.index');
    }

    public function show(Category $category)
    {
        return view('admin.category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Category $category, Request $request)
    {
        $this->validates($request, 'Could not save category');

        $category->update($request->all());

        flash('Category has been saved', 'success');

        return \Redirect::route('admin.category.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        flash('Category has been deleted', 'success');

        return \Redirect::route('admin.category.index');
    }
}
