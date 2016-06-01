<?php

namespace App\Console\Commands;

use App\Jobs\LdapImportUserJob;
use Illuminate\Console\Command;

class LdapImportUser extends Command
{
    protected $signature = 'ldap:import-user {user}';
    
    protected $description = 'Import one user from Active Directory';
    
    protected $params = [];


    public function handle()
    {
        dispatch(new LdapImportUserJob($this->argument('user')));
    }
}
