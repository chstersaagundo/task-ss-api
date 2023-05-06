<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('tasks:update-status')->everyMinute();
        $schedule->command('tasks:notification')->everyMinute();
        $schedule->command('tasks:tasks')->everyMinute();
    }

    protected $commands = [
        \App\Console\Commands\RunScheduledTasks::class,
        \App\Console\Commands\NotificationCommand::class,
        \App\Console\Commands\TaskCommand::class,
    ];
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
