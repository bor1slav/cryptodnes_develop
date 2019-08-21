<?php

namespace App\Console;

use App\Console\Commands\SyncCoinsDataCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SyncCoinsDataCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('gecko:coins:data')
            ->cron("*/4 * * * *")->name('update_crypto')->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/update_crypto.log'));

//        $schedule->command(FeedCoinsCommand::class)->everyMinute();
//        $schedule->command(FeedCoinsCommand::class)->everyMinute();
//        $schedule->job(new SyncCoinsDataJob)->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
