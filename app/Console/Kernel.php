<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        Commands\UpdateColumnValueCommand::class ,
        Commands\DeleteCodeCommand::class ,
        Commands\DeleteUnVerifiedPlayerCommand::class
            ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:update-task')
        ->dailyAt('00:00');

        $schedule->command('command:delete-code')
        ->dailyAt('00:00');

        $schedule->command('command:delete-player')
        ->dailyAt('00:00');

        $schedule->command('command:delete-program')
        ->weekly();;
        
        
        
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
