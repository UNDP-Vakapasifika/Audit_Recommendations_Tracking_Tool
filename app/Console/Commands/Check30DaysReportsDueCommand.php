<?php

namespace App\Console\Commands;

use App\Models\FinalReport;
use App\Models\User;
use App\Notifications\RemindReport30DayDueNotification;
use Illuminate\Console\Command;

class Check30DaysReportsDueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check30-days-reports-due-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check 30 days reports due and send notification to the responsible persons.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch reports that are due in exactly 30 days and not fully implemented
        $reports = FinalReport::whereDate('target_completion_date', '=', now()->addDays(30))
            ->where('current_implementation_status', '!=', 'Fully Implemented')
            ->get();

        // Notify the users related to each report
        foreach ($reports as $report) {
            $this->notifyRelatedUsers($report);
        }

    }

    /**
     * Notify all related users about the report.
     */
    private function notifyRelatedUsers($report)
    {
        $relatedUserIds = [
            $report->sai_responsible_person_id,
            $report->head_of_audited_entity_id,
            $report->audited_entity_focal_point_id,
            $report->audit_team_lead_id
        ];

        // Fetch all users based on the IDs
        $users = User::whereIn('id', $relatedUserIds)->get();
        //  dd($users);
        // Send notification to each user
        foreach ($users as $user) {
            $user->notify(new RemindReport30DayDueNotification($report));
        }
    }
}
