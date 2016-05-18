<?php

namespace App\Http\Controllers\Admin;

use App\BusinessRule;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessRuleRequest;

class BusinessRuleController extends Controller
{
    public function index()
    {
        $businessRules = BusinessRule::paginate();

        return view('admin.business-rule.index', compact('businessRules'));
    }

    public function create()
    {
        return view('admin.business-rule.create');
    }

    public function store(BusinessRuleRequest $request)
    {
        $rule = BusinessRule::create($request->all());
        $rule->updateCriteria($request->criterions);
        $rule->updateRules($request->rules);

        flash('Business rule has been saved', 'success');

        return \Redirect::route('admin.business-rule.index');
    }

    public function show(BusinessRule $business_rule)
    {
        return view('admin.business-rule.show', compact('business_rule'));
    }

    public function edit(BusinessRule $business_rule)
    {
        $business_rule->load(['criterions', 'rules']);

        return view('admin.business-rule.edit', compact('business_rule'));
    }

    public function update(BusinessRule $business_rule, BusinessRuleRequest $request)
    {
        $business_rule->update($request->all());
        $business_rule->updateCriteria($request->criterions);
        $business_rule->updateRules($request->rules);

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
