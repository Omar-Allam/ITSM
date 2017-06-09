<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function home()
    {
        $url = '/ticket';
        if (\Auth::guest()) {
            $url = '/login';
        }

        return \Redirect::to($url);
    }

    function changeLanguage($language)
    {
        \Session::forget('personlized-language-ar' . \Auth::user()->id);
        \Session::forget('personlized-language-en' . \Auth::user()->id);
        if($language=='ar'){
            \Session::put('personlized-language-ar' . \Auth::user()->id, $language);
        }
        else{
            \Session::put('personlized-language-en' . \Auth::user()->id, $language);
        }
        return redirect()->back();
    }
}

