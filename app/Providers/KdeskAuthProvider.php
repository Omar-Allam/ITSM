<?php

namespace App\Providers;

use App\Auth\KdeskUserProvider;
use Illuminate\Support\ServiceProvider;

class KdeskAuthProvider extends ServiceProvider
{
    public function boot()
    {
        \Auth::provider('kdesk', function ($app, $config) {
            return new KdeskUserProvider($app['hash'], $config['model']);
        });
    }

    public function register()
    {

    }
}
