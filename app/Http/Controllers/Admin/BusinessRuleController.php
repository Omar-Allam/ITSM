<?php

namespace App\Http\Controllers\Admin;

use App\BusinessRule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusinessRuleController extends Controller
{

    protected $rules = ['name' => 'required'];

    public function index()
    {
        $businessRules = BusinessRule::paginate();

        return view('admin.business-rule.index', compact('businessRules'));
    }

    public function create()
    {
        return view('admin.business-rule.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save business rule');

        BusinessRule::create($request->all());

        flash('Business rule has been saved', 'success');

        return \Redirect::route('admin.business-rule.index');
    }

    public function show(BusinessRule $business_rule)
    {
        return view('admin.business-rule.show', compact('business_rule'));
    }

    public function edit(BusinessRule $business_rule)
    {
        return view('admin.business-rule.edit', compact('business_rule'));
    }

    public function update(BusinessRule $business_rule, Request $request)
    {
        $this->validates($request, 'Could not save business rule');

        $business_rule->update($request->all());

        flash('Business rule has been saved', 'success');

        return \Redirect::route('admin.business-rule.index');
    }

    public function destroy(BusinessRule $business_rule)
    {
        $business_rule->delete();

        flash('Business rule has been deleted', 'success');

        return \Redirect::route('admin.business-rule.index');
    }
}
