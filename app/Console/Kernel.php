<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\Check30DaysReportsDueCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

        protected $commands = [
                Check30DaysReportsDueCommand::class,
                \App\Console\Commands\ClearLogsAndMigrate::class,
        ];

        protected function schedule(Schedule $schedule): void
        {
                // Schedule the email notifications to be sent daily at 8 AM
                $schedule->command('email:send-consolidated-notifications')
                        ->dailyAt('8:00')
                        ->timezone('Africa/Blantyre'); 

                // Schedule the 30 days reports due check to be sent daily at 8 AM
                $schedule->command('app:check30-days-reports-due-command')
                        ->dailyAt('1:30');

                // Schedule the 20 days reports due check to be sent daily at 8 AM
                $schedule->command('app:check20-days-reports-due-command')
                        ->dailyAt('1:30');

                // Schedule the 5 days reports due check to be sent daily at 8 AM
                $schedule->command('app:check5-days-reports-due-command')
                        ->dailyAt('1:30');

                // Schedule the Check30DaysReportsDueCommand to run every day at 8:00 AM
                $schedule->command('app:check30-days-reports-due-command')
                        ->dailyAt('08:00');

                $schedule->command('app:check30-days-summary-for-stakeholders')
                        ->dailyAt('08:00');
                
                // Schedule the Check30DaysReportsDueCommand to run every day at 8:00 AM
                $schedule->command('app:check30-days-reports-due-command')
                        ->dailyAt('22:25')
                        ->timezone('Africa/Blantyre');

                $schedule->command('app:check30-days-summary-for-stakeholders')
                        ->dailyAt('22:28')
                        ->timezone('Africa/Blantyre');
                
                $schedule->command('app:check30-days-reports-due-command')
                        ->everyMinute();

        }

               

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }


}
