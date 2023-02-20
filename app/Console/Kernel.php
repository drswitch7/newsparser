<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        Commands\NewsLoader::class,
        Commands\MyNewsFeeds::class,
        // Commands\LoadNewsFormDB::class,
        // 'App\Console\Commands\CallRoute',
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('api:newsloader')->everyMinute();
        $schedule->command('load:newsfeed')->everyMinute();
        // $schedule->command('load:newsdata')->hourly();
    }

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
