<?php

namespace App\Jobs;

use App\Auth\LdapConnect;
use App\BusinessUnit;
use App\Jobs\Job;
use App\Location;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LdapImportUserJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var string
     */
    private $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function


    handle()
    {
        $ldap = new LdapConnect(true);
        $data = $ldap->getUserData($this->username, [
            'samaccountname', 'mail', 'company', 'wwwhomepage', 'l', 'displayname',
            'title', 'telephoneNumber', 'manager'
        ]);

        $businessUnit = BusinessUnit::whereName($data['company'])->first();
        $location = Location::whereName($data['l'])->first();

        $user = [
            'name' => $data['displayname'],
            'login' => $data['samaccountname'],
            'email' => $data['mail'],
            'employee_id' => $data['wwwhomepage'],
            'business_unit_id' => $businessUnit->id,
            'location_id' => $location->id,
            'phone' => $data['telephonenumber'],
            'job' => $data['title'],
            'is_ad' => true
        ];

        if (empty($data['manager'])) {
            $token = explode(',', $data['manager']);
            $cn = '(' . array_shift($token) . ')';
            $ou = implode(',', $token);
            $entries = $ldap->fetch($cn, ['samaccountname', 'displayname'], $ou);
            $entry = $entries[0];

            $manager = User::whereLogin($entry['samaccountname'])->first();
            if ($manager) {
                $user['manager_id'] = $manager->id;
            }
        }

        $dbUser = User::whereLogin($data['samaccountname'])->first();

        if ($dbUser) {
            $dbUser->update($user);
            echo $dbUser->id;
        } else {
            echo User::create($user)->id;
        }
    }
}
