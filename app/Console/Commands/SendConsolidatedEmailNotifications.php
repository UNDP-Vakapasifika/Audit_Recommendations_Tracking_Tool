<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ActionPlanController; 

// class SendConsolidatedEmailNotifications extends Command
// {
//     /**
//      * The name and signature of the console command.
//      *
//      * @var string
//      */
//     protected $signature = 'app:send-consolidated-email-notifications';

//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = 'Command description';

//     /**
//      * Execute the console command.
//      */
//     public function handle()
//     {
//         //
//     }
// }


class SendConsolidatedEmailNotifications extends Command
{
    protected $signature = 'email:send-consolidated-notifications';

    protected $description = 'Send consolidated email notifications to responsible persons';

    public function handle()
    {
        app()->make(ActionPlanController::class)->sendConsolidatedEmailNotifications();
        $this->info('Consolidated email notifications sent successfully.');
    }
}
