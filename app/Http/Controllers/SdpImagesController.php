<?php

namespace App\Http\Controllers;


class SdpImagesController extends Controller
{
    function redirect()
    {
        return redirect()->to(config('services.sdp.base_url') . request()->getRequestUri());
    }
}