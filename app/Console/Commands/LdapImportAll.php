<?php

namespace App\Console\Commands;

use App\Auth\LdapConnect;
use App\Jobs\LdapSync;
use Illuminate\Console\Command;

class LdapImportAll extends Command
{
    protected $signature = 'ldap:import-all';

    protected $description = 'Import all available users from Active Directory';

    use LdapSync;

    /**
     * @var LdapConnect
     */
    private $ldap;

    public function __construct()
    {
        $this->ldap = new LdapConnect(true);
        parent::__construct();
    }

    public function handle()
    {
        $users = $this->ldap->fetch('(ObjectClass=User)', self::$attributes, 'OU=Alkifah,DC=alkifah,DC=com');
        set_time_limit(15 * count($users));
        foreach ($users as $user) {
            $this->syncEntry($this->ldap, $user);
        }
    }
}
