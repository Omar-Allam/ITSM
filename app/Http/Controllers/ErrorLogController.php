<?php

namespace App\Http\Controllers;

use App\ErrorLog;
use Illuminate\Http\Request;

class ErrorLogController extends Controller
{

    function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $errorLogs = ErrorLog::latest()->paginate(25);

        return view('error-log.index', compact('errorLogs'));
    }

    public function show(ErrorLog $errorLog)
    {
        return view('error-log.show', compact('errorLog'));
    }
}
