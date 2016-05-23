<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    protected $rules = ['name' => 'required'];

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function validates(Request $request, $flashMsg = '')
    {
        $input = $request->all();
        $validator = \Validator::make($input, $this->rules);
        if ($validator->fails()) {
            if ($flashMsg) {
                flash($flashMsg);
            }

            \Redirect::back()->withErrors($validator)->withInput($input)->send();
            abort(302);
        }
    }

    protected function backSuccessResponse(Request $request, $msg)
    {
        if ($request->wantsJson() || $request->isJson()) {
            return ['ok' => true, 'message' => $msg];
        }

        flash($msg, 'success');

        return \Redirect::back();
    }
}
