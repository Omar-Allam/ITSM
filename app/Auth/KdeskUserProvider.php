<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class KdeskUserProvider extends EloquentUserProvider
{
    public function validateCredentials(UserContract $user, array $credentials)
    {
        if (parent::validateCredentials($user, $credentials)) {
            return true;
        }

        if ($user->is_ad) {
            return $this->validateLDAP($credentials);
        }

        return false;
    }

    protected function validateLDAP($credentials)
    {
        $ldap = new LdapConnect();
        return $ldap->validateLogin($credentials);
    }

}