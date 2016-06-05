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
     */
    protected function syncEntry(LdapConnect $ldap, $entry)
    {
        $businessUnit = BusinessUnit::whereName($entry['company'])->first();
        $location = Location::whereName($entry['l'])->first();

        $user = [
            'name' => $entry['displayname'],
            'login' => $entry['samaccountname'],
            'email' => $entry['mail'],
            'employee_id' => $entry['wwwhomepage'],
            'business_unit_id' => $businessUnit->id,
            'location_id' => isset($location) ? $location->id : '',
            'phone' => $entry['telephonenumber'],
            'job' => $entry['title'],
            'is_ad' => true
        ];

        if (!empty($entry['manager'])) {
            $token = explode(',', $entry['manager']);
            $cn = '(' . array_shift($token) . ')';
            $ou = implode(',', $token);
            $entries = $ldap->fetch($cn, ['samaccountname', 'displayname'], $ou);
            $entry = $entries[0];

            $manager = User::whereLogin($entry['samaccountname'])->first();
            if ($manager) {
                $user['manager_id'] = $manager->id;
            }
        }

        $dbUser = User::whereLogin($entry['samaccountname'])->first();

        if ($dbUser) {
            $dbUser->update($user);
            echo $dbUser->id;
        } else {
            echo User::create($user)->id;
        }
    }
}