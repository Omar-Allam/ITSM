<?php

namespace App\Http\Controllers;

use App\Category;
use App\Subcategory;
use Illuminate\Http\Request;

use App\Http\Requests;

class CustomFieldsController extends Controller
{
    function render(Request $request)
    {
        $category = $subcategory = $item = null;
        if ($request->has('category')) {
            $category = Category::find($request->get('category'));
        }

        if ($request->has('subcategory')) {
            $subcategory = Subcategory::find($request->get('subcategory'));
        }

        if ($request->has('item')) {
            $item = Item::find($request->get('item'));
        }

        return view('custom-fields.render', compact('category', 'subcategory', 'item'));
    }
}
