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
    use InteractsWithQueue;

    use LdapSync;

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
    public function handle()
    {
        $ldap = new LdapConnect(true);
        $entry = $ldap->getUserData($this->username, self::$attributes);

        $this->syncEntry($ldap, $entry);
    }
    
}
