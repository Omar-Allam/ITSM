<?php

namespace App\Http\Controllers\Admin;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{

    protected $rules = ['name' => 'required', 'subcategory_id' => 'required|exists:subcategories,id', 'description' => 'max:500'];

    public function index()
    {
        $items = Item::paginate();

        return view('admin.item.index', compact('items'));
    }

    public function create(Request $request)
    {
        $subcategory_id = 0;
        if ($request->has('subcategory')) {
            $subcategory_id = $request->get('subcategory');
        }

        $item = new Item();
        return view('admin.item.create', compact('subcategory_id', 'item'));
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save item');
        $service_request = isset($request->service_request) ? 1 : 0;
        $data = $request->all();
        $data['service_request']=$service_request;
        $item = Item::create($data);

        flash('Item has been saved', 'success');

        return \Redirect::route('admin.subcategory.show', $item->subcategory_id);
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
        $service_request = isset($request->service_request) ? 1 : 0;
        $data = $request->all();
        $data['service_request']=$service_request;
        $item->update($data);

        flash('Item has been saved', 'success');

        return \Redirect::route('admin.subcategory.show', $item->subcategory_id);
    }

    public function destroy(Item $item)
    {
        $item->delete();

        flash('Item has been deleted', 'success');

        return \Redirect::route('admin.subcategory.show', $item->subcategory_id);
    }
}
