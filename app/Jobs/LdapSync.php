<?php
/**
 * Created by PhpStorm.
 * User: hazem
 * Date: 6/5/16
 * Time: 2:25 PM
 */

namespace App\Jobs;


use App\Auth\LdapConnect;
use App\BusinessUnit;
use App\Location;
use App\User;

trait LdapSync
{

    protected static $attributes = [
        'samaccountname', 'mail', 'company', 'wwwhomepage', 'l', 'displayname',
        'title', 'telephoneNumber', 'manager'
    ];

    /**
     * @param LdapConnect $ldap
     * @param $entry
     *
     * @return \App\User|boolean
     */
    protected function syncEntry(LdapConnect $ldap, $entry)
    {
        $businessUnit = !empty($entry['company'])? BusinessUnit::whereName($entry['company'])->first() : null;
        $location = !empty($entry['l']) ? Location::whereName($entry['l'])->first() : null;

        if (!$businessUnit || !$location) {
            return false;
        }

        $user = [
            'name' => $entry['displayname'],
            'login' => $entry['samaccountname'],
            'email' => $entry['mail'],
            'employee_id' => $entry['wwwhomepage'],
            'business_unit_id' => $businessUnit? $businessUnit->id : null,
            'location_id' => isset($location) ? $location->id : null,
            'phone' => !empty($entry['telephonenumber'])? $entry['telephonenumber'] : '',
            'job' => $entry['title'],
            'is_ad' => true
        ];

        if (!empty($entry['manager'])) {
            $token = explode(',', $entry['manager']);
            $cn = '(' . array_shift($token) . ')';
            $ou = implode(',', $token);
            $entries = $ldap->fetch($cn, ['samaccountname', 'displayname'], $ou);
            $managerEntry = $entries[0];

            $manager = User::whereLogin($managerEntry['samaccountname'])->first();
            if ($manager) {
                $user['manager_id'] = $manager->id;
            }
        }

        $dbUser = User::where('login', $entry['samaccountname'])->orWhere('email', $entry['mail'])->first();
        if ($dbUser) {
            $dbUser->update($user);
            return $dbUser;
        }

        return User::create($user);
    }
}