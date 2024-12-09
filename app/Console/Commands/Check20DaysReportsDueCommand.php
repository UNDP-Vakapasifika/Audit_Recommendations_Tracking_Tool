<?php

namespace App\Console\Commands;

use App\Models\FinalReport;
use App\Models\User;
use App\Notifications\RemindReport20DayDueNotification;
use Illuminate\Console\Command;

class Check20DaysReportsDueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check20-days-reports-due-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check 20 days reports due and send notification to the responsible person.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reports = FinalReport::whereDate('target_completion_date', '>', now())
            ->whereDate('target_completion_date', '=', now()->addDays(20))
            ->where('current_implementation_status', '!=', 'Fully Implemented')
            ->get();

        // from the reports get the unique responsible person
        $reports = $reports->unique('responsible_person');

        foreach ($reports as $report) {
            $user = User::where('name', $report->responsible_person)->first();

            if ($user) {
                $user->notify(new RemindReport20DayDueNotification());
            }
        }
    }
}
