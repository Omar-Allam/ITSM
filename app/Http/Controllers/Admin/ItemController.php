<?php

namespace App\Http\Controllers\Admin;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{

    protected $rules = ['name' => 'required', 'description' => 'max:500'];

    public function index()
    {
        $items = Item::paginate();

        return view('admin.item.index', compact('items'));
    }

    public function create()
    {
        return view('admin.item.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save item');

        Item::create($request->all());

        flash('Item has been saved', 'success');

        return \Redirect::route('admin.item.index');
    }

    public function show(Item $item)
    {
        return view('admin.item.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('admin.item.edit', compact('item'));
    }

    public function update(Item $item, Request $request)
    {
        $this->validates($request, 'Could not save item');

        $item->update($request->all());

        flash('Item has been saved', 'success');

        return \Redirect::route('admin.item.index');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        flash('Item has been deleted', 'success');

        return \Redirect::route('admin.item.index');
    }
}
