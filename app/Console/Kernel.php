<?php

namespace App\Console;

use App\Console\Commands\LdapImportUser;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Make\Console\Command\Module;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Module::class,
        LdapImportUser::class,
        Commands\LdapImportAll::class,
        Commands\AutoCloseResolvedTickets::class,
        Commands\EscalateApprovals::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Run the auto close tickets command twice every hour on working days
        $schedule->command('ticket:auto-close')
            ->sundays()->mondays()->tuesdays()->wednesdays()->thursdays()
            ->everyThirtyMinutes();

        // Escalate approvals every hour
        $schedule->command('approvals:escalate')->hourly();
    }
}
