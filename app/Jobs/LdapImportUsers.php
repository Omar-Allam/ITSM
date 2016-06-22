<?php

namespace App\Jobs;

use App\Auth\LdapConnect;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LdapImportUsers extends Job implements ShouldQueue
{
    use InteractsWithQueue;

    use LdapSync;

    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function handle()
    {
        $ldap = new LdapConnect(true);

        foreach ($this->users as $user) {
            $entry = $ldap->getUserData($user, self::$attributes);
            if (!$entry) {
                continue;
            }

            $this->syncEntry($ldap, $entry);
        }
    }
}
