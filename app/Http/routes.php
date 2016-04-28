<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function(\Illuminate\Routing\Router $r){
    $r->resource('region', 'Admin\RegionController');
    $r->resource('city', 'Admin\CityController');
    $r->resource('location', 'Admin\LocationController');
    $r->resource('business-unit', 'Admin\BusinessUnitController');
    $r->resource('branch', 'Admin\BranchController');
    $r->resource('department', 'Admin\DepartmentController');
    $r->resource('category', 'Admin\CategoryController');
    $r->resource('subcategory', 'Admin\SubcategoryController');
});

Route::resource('admin/item', 'Admin\ItemController');

Route::resource('admin/status', 'Admin\StatusController');

Route::resource('admin/group', 'Admin\GroupController');

Route::resource('admin/priority', 'Admin\PriorityController');

Route::resource('admin/urgency', 'Admin\UrgencyController');

Route::resource('admin/impact', 'Admin\ImpactController');
