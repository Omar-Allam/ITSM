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
        if (empty($entry['mail'])) {
            return false;
        }

        $businessUnit = !empty($entry['company'])? BusinessUnit::whereName($entry['company'])->first() : null;
        if (!$businessUnit) {
            return false;
        }

        $location = null;
        if (!empty($entry['l'])) {
            $location = Location::whereName(trim($entry['l']))->first();
        }

        if (!$location && $businessUnit->location) {
            $location = $businessUnit->location;
        }

        /*if (!$businessUnit || !$location || empty($entry['mail'])) {
            \Log::warning("<{$entry['samaccountname']}>");
            return false;
        }*/

        $user = [
            'name' => $entry['displayname'],
            'login' => $entry['samaccountname'],
            'email' => $entry['mail'],
            'employee_id' => !empty($entry['wwwhomepage'])? $entry['wwwhomepage'] : '',
            'business_unit_id' => $businessUnit? $businessUnit->id : null,
            'location_id' => isset($location) ? $location->id : null,
            'phone' => !empty($entry['telephonenumber'])? $entry['telephonenumber'] : '',
            'job' => !empty($entry['title'])?$entry['title'] : '',
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

        $dbUser = User::where('login', $user['login'])->orWhere('email', $user['email'])->first();
        if ($user['email'] == '') {
            dd($dbUser);
        }
        if ($dbUser) {
            $dbUser->update($user);
            return $dbUser;
        }

        return User::create($user);
    }
}