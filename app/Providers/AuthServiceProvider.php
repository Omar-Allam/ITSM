<?php

namespace App\Providers;

use App\Auth\KdeskUserProvider;
use App\Policies\TicketPolicy;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Ticket' => TicketPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        \Auth::provider('hubdesk', function ($app) {
            return new KdeskUserProvider(app(Hasher::class), config('auth.providers.users.model'));
        });

        \Gate::before(function (User $user) {
            if ($user->isAdmin()) {
                return true;
            }
        });

        $this->registerPolicies();
    }
}
