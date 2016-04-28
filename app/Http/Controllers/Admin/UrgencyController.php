<?php

namespace App\Http\Controllers\Admin;

use App\Urgency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UrgencyController extends Controller
{

    protected $rules = ['name' => 'required'];

    public function index()
    {
        $urgencies = Urgency::paginate();

        return view('admin.urgency.index', compact('urgencies'));
    }

    public function create()
    {
        return view('admin.urgency.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save urgency');

        Urgency::create($request->all());

        flash('Urgency has been saved', 'success');

        return \Redirect::route('admin.urgency.index');
    }

    public function show(Urgency $urgency)
    {
        return view('admin.urgency.show', compact('urgency'));
    }

    public function edit(Urgency $urgency)
    {
        return view('admin.urgency.edit', compact('urgency'));
    }

    public function update(Urgency $urgency, Request $request)
    {
        $this->validates($request, 'Could not save urgency');

        $urgency->update($request->all());

        flash('Urgency has been saved', 'success');

        return \Redirect::route('admin.urgency.index');
    }

    public function destroy(Urgency $urgency)
    {
        $urgency->delete();

        flash('Urgency has been deleted', 'success');

        return \Redirect::route('admin.urgency.index');
    }
}
