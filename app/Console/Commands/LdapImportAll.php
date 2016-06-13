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
        $count = count($users);
        set_time_limit(15 * $count);

        $bar = $this->output->createProgressBar($count);
        foreach ($users as $user) {
            if (!$this->syncEntry($this->ldap, $user)) {
//                dump($user);
            }
            $bar->advance();
        }
    }
}
