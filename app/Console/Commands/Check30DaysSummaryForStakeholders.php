<?php

namespace App\Console\Commands;

use App\Models\FinalReport;
use App\Models\User;
use App\Notifications\RemindStakeholders30DaySummaryNotification;
use Illuminate\Console\Command;

class Check30DaysSummaryForStakeholders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check30-days-summary-for-stakeholders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Provide a summary of recommendations due in 30 days to stakeholders.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch reports that are due in exactly 30 days and not fully implemented
        $reports = FinalReport::whereDate('target_completion_date', '=', now()->addDays(30))
            ->where('current_implementation_status', '!=', 'Fully Implemented')
            ->get();

        // Get the total number of recommendations and reports due
        $totalRecommendations = $reports->sum(function ($report) {
            return $report->audit_recommendations->count();
        });

        $totalReports = $reports->count();

        // Get the unique client IDs from the reports
        $uniqueClients = $reports->pluck('client_id')->unique()->count();

        // Find all users with a non-null stakeholder_id
        $stakeholderUsers = User::whereNotNull('stakeholder_id')->get();

        // Send the summary notification to each stakeholder user
        foreach ($stakeholderUsers as $user) {
            $user->notify(new RemindStakeholders30DaySummaryNotification($totalRecommendations, $totalReports, $uniqueClients));
        }
    }
}
