<?php

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::group(['prefix' => 'list'], function (\Illuminate\Routing\Router $r) {
    $r->get('/subcategory/{cat_id?}', 'ListController@subcategory');
    $r->get('/item/{subcat_id?}', 'ListController@item');
    $r->get('/category', 'ListController@category');
    $r->get('/location', 'ListController@location');
    $r->get('/business-unit', 'ListController@businessUnit');
    $r->get('/priority', 'ListController@priority');
    $r->get('/urgency', 'ListController@urgency');
    $r->get('/impact', 'ListController@impact');
    $r->get('/support-groups', 'ListController@supportGroup');
    $r->get('/technician', 'ListController@technician');
});

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth']], function (\Illuminate\Routing\Router $r) {
    $r->resource('region', 'Admin\RegionController');
    $r->resource('city', 'Admin\CityController');
    $r->resource('location', 'Admin\LocationController');
    $r->resource('business-unit', 'Admin\BusinessUnitController');
    $r->resource('branch', 'Admin\BranchController');
    $r->resource('department', 'Admin\DepartmentController');
    $r->resource('category', 'Admin\CategoryController');
    $r->resource('subcategory', 'Admin\SubcategoryController');
    $r->resource('item', 'Admin\ItemController');
    $r->resource('status', 'Admin\StatusController');
    $r->resource('group', 'Admin\GroupController');
    $r->resource('priority', 'Admin\PriorityController');
    $r->resource('urgency', 'Admin\UrgencyController');
    $r->resource('impact', 'Admin\ImpactController');
    $r->resource('business-rule', 'Admin\BusinessRuleController');
    $r->resource('sla', 'Admin\SlaController');
    $r->resource('user', 'Admin\UserController');
});

Route::group(['middleware' => ['auth']], function () {
    Route::resource('ticket', 'TicketController');
    Route::group(['prefix' => 'ticket'], function (\Illuminate\Routing\Router $r) {
        $r->post('resolution/{ticket}', ['as' => 'ticket.resolution', 'uses' => 'TicketController@resolution']);
        $r->post('reply/{ticket}', ['as' => 'ticket.reply', 'uses' => 'TicketController@reply']);
        $r->post('jump', ['as' => 'ticket.jump', 'uses' => 'TicketController@jump']);
        $r->post('reassign/{ticket}', ['as' => 'ticket.reassign', 'uses' => 'TicketController@reassign']);
        $r->post('scope', ['as' => 'ticket.scope', 'uses' => 'TicketController@scope']);
    });

    Route::group(['prefix' => 'approval'], function (\Illuminate\Routing\Router $r) {
        $r->post('approval/{ticket}', ['as' => 'approval.send', 'uses' => 'ApprovalController@send']);
        $r->get('resend/{ticketApproval}', ['as' => 'approval.resend', 'uses' => 'ApprovalController@resend']);
        $r->get('/{ticketApproval}', ['as' => 'approval.show', 'uses' => 'ApprovalController@show']);
        $r->post('/{ticketApproval}', ['as' => 'approval.update', 'uses' => 'ApprovalController@update']);
        $r->delete('delete/{ticketApproval}', ['as' => 'approval.destroy', 'uses' => 'ApprovalController@destroy']);
    });
});



Route::auth();

Route::get('/home', 'HomeController@index');
