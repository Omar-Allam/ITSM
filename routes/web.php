<?php
Route::get('/', 'HomeController@home')->middleware('lang');

Route::auth();
Route::get('logout', 'Auth\LoginController@logout');
Route::get('auth/google', 'Auth\AuthController@googleRedirect');
Route::get('auth/google/continue', 'Auth\AuthController@googleHandle');

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
    $r->get('/group-technicians/{group?}', 'ListController@technicians');
    $r->get('/status', 'ListController@status');
    $r->get('/requester', 'ListController@requester');
    $r->get('/group', 'ListController@supportGroup');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin'], 'as' => 'admin.'], function (\Illuminate\Routing\Router $r) {
    $r->get('', 'Admin\DashboardController@index');
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

    Route::group(['prefix' => 'group'], function () {
        Route::post('add-user/{group}', ['uses' => 'Admin\GroupController@addUser', 'as' => 'admin.group.add-user']);
        Route::delete('remove-user/{group}/{user}', ['uses' => 'Admin\GroupController@removeUser', 'as' => 'admin.group.remove-user']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::post('ldap-import', ['as' => 'user.ldap-import', 'uses' => 'Admin\UserController@ldapImport']);
    });
});

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'ticket'], function (\Illuminate\Routing\Router $r) {
        $r->post('resolution/{ticket}', ['as' => 'ticket.resolution', 'uses' => 'TicketController@resolution']);
        $r->post('edit-resolution/{ticket}', ['as' => 'ticket.edit-resolution', 'uses' => 'TicketController@editResolution']);
        $r->post('note/{ticket}', ['as' => 'ticket.note', 'uses' => 'TicketController@addNote']);
        $r->post('note-edit/{note}', ['as' => 'note.edit', 'uses' => 'TicketController@editNote']);
        $r->post('remove-note/{note}', ['as' => 'note.remove', 'uses' => 'TicketController@deleteNote']);
        $r->post('reply/{ticket}', ['as' => 'ticket.reply', 'uses' => 'TicketController@reply']);
        $r->post('jump', ['as' => 'ticket.jump', 'uses' => 'TicketController@jump']);
        $r->post('reassign/{ticket}', ['as' => 'ticket.reassign', 'uses' => 'TicketController@reassign']);
        $r->post('scope', ['as' => 'ticket.scope', 'uses' => 'TicketController@scope']);
        $r->get('duplicate/{ticket}', ['as' => 'ticket.duplicate', 'uses' => 'TicketController@duplicate']);
        $r->post('filter', ['as' => 'ticket.filter', 'uses' => 'TicketController@filter']);
        $r->get('clear', ['as' => 'ticket.clear', 'uses' => 'TicketController@clear']);
        $r->get('pickup/{ticket}', ['as' => 'ticket.pickup', 'uses' => 'TicketController@pickupTicket']);
        $r->get('tasks/{ticket}', ['as' => 'tasks.index', 'uses' => 'TaskController@index']);
        $r->get('tasks/edit/{task}', ['as' => 'tasks.edit', 'uses' => 'TaskController@edit']);
        $r->post('tasks/{ticket}', ['as' => 'tasks.store', 'uses' => 'TaskController@store']);
        $r->patch('tasks/{ticket}', ['as' => 'tasks.update', 'uses' => 'TaskController@update']);
        $r->delete('tasks/{ticket}/{task}', ['as' => 'tasks.delete', 'uses' => 'TaskController@destroy']);
        $r->get('print/{ticket}', ['as' => 'ticket.print', 'uses' => 'TicketPrintController@show']);
    });

    Route::resource('ticket', 'TicketController');

    Route::group(['prefix' => 'approval'], function (\Illuminate\Routing\Router $r) {
        $r->post('approval/{ticket}', ['as' => 'approval.send', 'uses' => 'ApprovalController@send']);
        $r->get('resend/{ticketApproval}', ['as' => 'approval.resend', 'uses' => 'ApprovalController@resend']);
        $r->get('/{ticketApproval}', ['as' => 'approval.show', 'uses' => 'ApprovalController@show']);
        $r->post('/{ticketApproval}', ['as' => 'approval.update', 'uses' => 'ApprovalController@update']);
        $r->delete('delete/{ticketApproval}', ['as' => 'approval.destroy', 'uses' => 'ApprovalController@destroy']);
    });

    Route::get('/get-tasks/{ticket}', ['as' => 'tasks.ticket', 'uses' => 'TaskController@getTasksOfTicket']);
    Route::resource('task', 'TaskController');

    Route::get('/home', 'HomeController@index');

    Route::get('/custom-fields', 'CustomFieldsController@render');

    Route::get('/report', 'ReportController@index');
    Route::get('/report/result', 'ReportController@show');
    Route::post('/report/result', 'ReportController@show');

    Route::get('language/{language}', ['as' => 'site.changeLanguage', 'uses' => 'HomeController@changeLanguage'])->middleware('lang');
});

Route::get('inlineimages/{any?}', 'SdpImagesController@redirect')->where('any', '(.*)');

Route::resource('error-log', 'ErrorLogController');
Route::resource('reports', 'ReportsController');
