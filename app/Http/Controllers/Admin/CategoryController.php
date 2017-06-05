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
        $service_request = isset($request->service_request) ? 1 : 0;
        Category::create([$request->all(), 'service_request'=>$service_request]);

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
        $service_request = isset($request->service_request) ? 1 : 0;
        $category->update([$request->all(), 'service_request'=>$service_request]);

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
