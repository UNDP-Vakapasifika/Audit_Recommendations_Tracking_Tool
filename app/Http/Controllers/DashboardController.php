<?php

namespace App\Http\Controllers;

use App\Models\FinalReport;
use App\Models\UserActivity;
use Illuminate\Contracts\View\View;


class DashboardController extends Controller
{
    public function index(): View
    {
        $fullyImplementedCount = FinalReport::where('current_implementation_status', 'Fully Implemented')
            ->when(auth()->user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })->count();
        $partiallyImplementedCount = FinalReport::where('current_implementation_status', 'Partially Implemented')
            ->when(auth()->user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })->count();
        $notImplementedCount = FinalReport::where('current_implementation_status', 'Not Implemented')
            ->when(auth()->user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })->count();
        $noupdateImplementedCount = FinalReport::where('current_implementation_status', 'No Update')
            ->when(auth()->user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })->count();
        $allRecommendationsCount = FinalReport::when(auth()->user()->hasRole('Client'), function ($query) {
            $query->where('client_id', auth()->user()->lead_body_id);
        })->count();

        $chartLabels = ['Fully Implemented', 'Partially Implemented', 'Not Implemented', 'No Update'];
        $chartDatasets = [
            [
                'label' => 'Implementations Status Summary',
                'data' => [$fullyImplementedCount, $partiallyImplementedCount, $notImplementedCount, $noupdateImplementedCount],
                'backgroundColor' => ['rgba(75, 192, 192, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                'borderColor' => ['rgba(75, 192, 192, 1)', 'rgba(255, 206, 86, 1)', 'rgba(255, 99, 132, 1)'],
                'borderWidth' => 1,
            ],

        ];

        // Join FinalReport and LeadBody tables to retrieve distinct lead body names
        $distinctLeadBodies = FinalReport::with('leadBody')
            ->when(auth()->user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })
            ->distinct()
            ->leftJoin('lead_bodies', 'final_reports.client_id', '=', 'lead_bodies.id')
            ->pluck('lead_bodies.name');

        // Initialize arrays to store data for chart
        $chartLabels2 = [];
        $chartData = [];

        // Iterate through distinct lead bodies
        foreach ($distinctLeadBodies as $leadBody) {
            // Count the number of FinalReport records where the lead body name matches the given leadBody
            $leadBodyCount = FinalReport::whereHas('leadBody', function ($query) use ($leadBody) {
                $query->where('name', $leadBody);
            })->count();
            // Add lead body to labels array
            $chartLabels2[] = $leadBody;

            // Add lead body count to data array
            $chartData[] = $leadBodyCount;
        }

        // Chart datasets using the collected data
        $chartDatasets2 = [
            [
                'label' => 'Number of Records per Lead Body',
                'data' => $chartData,
                'backgroundColor' => ['rgba(75, 192, 192, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                'borderColor' => ['rgba(75, 192, 192, 1)', 'rgba(255, 206, 86, 1)', 'rgba(255, 99, 132, 1)'],
                'borderWidth' => 1,
            ],
        ];

        // Join FinalReport and LeadBody tables to fetch unique lead body names and convert the result to an array
        $leadBodies2 = FinalReport::join('lead_bodies', 'final_reports.client_id', '=', 'lead_bodies.id')
            ->distinct()
            ->pluck('lead_bodies.name')
            ->toArray();

        // Initialize arrays for labels and datasets
        $radarLabels = [];
        $radarDatasets = [];

        foreach ($leadBodies2 as $leadBody) {
            // Count recommendations for the current lead body where recurrence is set to 'Yes'
            $recommendationCount = FinalReport::whereHas('leadBody', function ($query) use ($leadBody) {
                $query->where('name', $leadBody);
            })->where('recurrence', 'Yes')
                ->count();

            // Generate a random color for the current lead body
            $randomColor = 'rgba(' . mt_rand(0, 255) . ', ' . mt_rand(0, 255) . ', ' . mt_rand(0, 255) . ', 0.2)'; // Using alpha for transparency

            // Add the lead body to radarLabels
            $radarLabels[] = $leadBody;

            // Build dataset for the current lead body with random colors
            $dataset = [
                'label' => $leadBody,
                'data' => [$recommendationCount],
                'backgroundColor' => $randomColor,
                'borderColor' => $randomColor,
                'borderWidth' => 1,
                'lineTension' => 0,
            ];

            // Add the dataset to the radarDatasets array
            $radarDatasets[] = $dataset;
        }

        $calendarEventsCount = FinalReport::groupBy('target_completion_date')
            ->when(auth()->user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })
            ->selectRaw('count(*) as count, target_completion_date as date')
            ->whereNotNull('target_completion_date')
            ->orderBy('target_completion_date')
            ->get();

        $calendarEvents = [];

        foreach ($calendarEventsCount as $event) {
            $count = $event->count;
            $date = $event->date;

            $calendarEvents[] = [
                'title' => $count > 1 ? $count . ' Recommendations' : $count . ' Recommendation',
                'id' => rand(2, 8),
                'start' => $date,
                'end' => $date,
            ];
        }

        // Get users and their activity counts
        $userActivityCounts = UserActivity::select('user_id', \DB::raw('count(*) as activity_count'))
            ->groupBy('user_id')
            ->with('user') // Load the related user
            ->get();

        // Get the latest activities for each user
        $recentActivities = UserActivity::with('user')
            ->latest()
            ->get()
            ->groupBy('user_id')
            ->map(function ($activities) {
                return $activities->take(5); // Limit to the top 5 activities per user
            });

        return view('dashboard', compact(
            'chartLabels',
            'radarDatasets',
            'radarLabels',
            'chartDatasets',
            'calendarEvents',
            'chartDatasets2',
            'chartLabels2',
            'fullyImplementedCount',
            'partiallyImplementedCount',
            'notImplementedCount',
            'noupdateImplementedCount',
            'allRecommendationsCount',
            'recentActivities',
            'userActivityCounts'
        ));
    }
}
