<?php

namespace App\Http\Controllers;

use App\Models\FinalReport;
use App\Models\LeadBody;
use App\Models\ClientType;
use App\Models\MainstreamCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Stakeholder;
use App\Models\User;
use App\Models\Tool;
use Illuminate\Support\Facades\Redirect;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Check if the 'stakeholders' or 'users' tables are empty
        if (Stakeholder::count() == 0 || User::count() == 0) {
            // Redirect to the setup page
            return Redirect::route('setup.index');
        }

        // Retrieve the filters from the request
        $selectedFilters = $request->only([
            'filter_fully_implemented',
            'filter_recurrence',
            'filter_not_implemented',
            'filter_noupdate',
            'filter_partially_implemented',
            'filter_status',
            'filter_audit_report_title',
            'filter_country_office',
            'filter_start_date',
            'filter_end_date',
            'filter_client_types',
            'filter_mainstream_gender',
        ]);

        // Initialize filter variables
        $filter_fully_implemented = isset($selectedFilters['filter_fully_implemented']);
        $filter_not_implemented = isset($selectedFilters['filter_not_implemented']);
        $filter_noupdate = isset($selectedFilters['filter_noupdate']);
        $filter_partially_implemented = isset($selectedFilters['filter_partially_implemented']);
        $filter_status = $selectedFilters['filter_status'] ?? 'all';
        $filter_audit_report_title = $selectedFilters['filter_audit_report_title'] ?? '';
        $filter_country_office = $selectedFilters['filter_country_office'] ?? '';
        $filter_start_date = $selectedFilters['filter_start_date'] ?? '';
        $filter_end_date = $selectedFilters['filter_end_date'] ?? '';
        $filter_recurrence = $selectedFilters['filter_recurrence'] ?? '';
        $filter_audit_type = $selectedFilters['filter_audit_type'] ?? 'all';


        // Initialize the base query
        $query = FinalReport::query();
        
        // Apply filters for current implementation status
        if ($filter_fully_implemented) {
            $query->where('current_implementation_status', 'Fully Implemented');
        }
        if ($filter_recurrence) {
            $query->where('recurrence', $filter_recurrence);
        }
        if ($filter_not_implemented) {
            $query->where('current_implementation_status', 'Not Implemented');
        }
        if ($filter_noupdate) {
            $query->where('current_implementation_status', 'No Update');
        }
        if ($filter_partially_implemented) {
            $query->where('current_implementation_status', 'Partially Implemented');
        }
        if ($filter_status !== 'all') {
            $query->where('current_implementation_status', $filter_status);
        }
        if (!empty($filter_audit_report_title)) {
            $query->where('audit_report_title', $filter_audit_report_title);
        }
        if (!empty($filter_country_office)) {
            $query->where('country_office', $filter_country_office);
        }
        if (!empty($filter_start_date)) {
            $startDate = Carbon::parse($filter_start_date)->startOfDay();
            $query->whereDate('publication_date', '>=', $startDate);
        }
        if (!empty($filter_end_date)) {
            $endDate = Carbon::parse($filter_end_date)->endOfDay();
            $query->whereDate('publication_date', '<=', $endDate);
        }

        if (!empty($selectedFilters['filter_client_types'])) {
            $query->whereHas('leadBody', function ($q) use ($selectedFilters) {
                $q->where('client_type_id', $selectedFilters['filter_client_types']);
            });
        }
    
        if (!empty($selectedFilters['filter_mainstream_gender'])) {
            $query->whereHas('mainstreamCategory', function ($q) use ($selectedFilters) {
                $q->where('name', $selectedFilters['filter_mainstream_gender']);
            });
        }

        // $filter_audit_type = $selectedFilters['filter_audit_type'] ?? 'all';
        $filter_audit_type = $request->input('filter_audit_type', 'all');


        if ($filter_audit_type !== 'all') {
            $query->where('audit_type', $filter_audit_type);
        }

        $filter_risk_level = $request->input('filter_risk_level', 'all');

        if ($filter_risk_level !== 'all') {
            $query->where('classification', $filter_risk_level);
        }

        
        // Add joins and selections to fetch the associated names
        // $query->leftJoin('lead_bodies', 'final_reports.client_id', '=', 'lead_bodies.id')
        //     ->leftJoin('client_types', 'lead_bodies.client_type_id', '=', 'client_types.id')
        //     ->leftJoin('mainstream_categories', 'final_reports.mainstream_categories_id', '=', 'mainstream_categories.id')
        //     ->select('final_reports.*', 'lead_bodies.name as client_name', 'client_types.name as client_type_name', 'mainstream_categories.name as category_name');

        // Additional joins and selections for fetching client type and mainstream gender
        $query->leftJoin('lead_bodies', 'final_reports.client_id', '=', 'lead_bodies.id')
        ->leftJoin('client_types', 'lead_bodies.client_type_id', '=', 'client_types.id')
        ->leftJoin('mainstream_categories', 'final_reports.mainstream_categories_id', '=', 'mainstream_categories.id')
        ->select(
            'final_reports.*',
            'lead_bodies.name as client_name',
            'client_types.name as client_type_name',
            'mainstream_categories.name as mainstream_gender'
        );
        // dd($query);
        // Get the filtered recommendations
        // $filteredRecommendations = $query->get();
        $filteredRecommendations = $query->with(['mainstreamCategory'])
                                   ->get();

        // Calculate statistics based on filtered recommendations
        $fullyImplementedCount = $filteredRecommendations->where('current_implementation_status', 'Fully Implemented')->count();
        $partiallyImplementedCount = $filteredRecommendations->where('current_implementation_status', 'Partially Implemented')->count();
        $notImplementedCount = $filteredRecommendations->where('current_implementation_status', 'Not Implemented')->count();
        $noupdateCount = $filteredRecommendations->where('current_implementation_status', 'No Update')->count();

        $totalRecommendationsCount = $filteredRecommendations->count();

        // Calculate percentages
        $percent_fully_implemented = ($totalRecommendationsCount > 0) ? round(($fullyImplementedCount / $totalRecommendationsCount) * 100) : 0;
        $percent_partially = ($totalRecommendationsCount > 0) ? round(($partiallyImplementedCount / $totalRecommendationsCount) * 100) : 0;
        $percent_not = ($totalRecommendationsCount > 0) ? round(($notImplementedCount / $totalRecommendationsCount) * 100) : 0;
        $percent_noupdate = ($totalRecommendationsCount > 0) ? round(($noupdateCount / $totalRecommendationsCount) * 100) : 0;

        // Retrieve distinct report titles and lead bodies
        $distinctReportTitles = FinalReport::distinct()->pluck('audit_report_title');
        $distinctLeadBodies = LeadBody::where('name', 'not like', 'SAI%')->distinct()->pluck('name');

        // Retrieve distinct client types and mainstream gender categories
        $distinctClientTypes = ClientType::distinct()->get(['id', 'name']);
        $distinctMainstreamGenders = MainstreamCategory::distinct()->get(['id', 'name']);


        // Calculate the total count of distinct lead bodies, report titles, and recurrence
        // $totalLeadBodies = FinalReport::distinct()->count('client_id');
        $totalLeadBodies = $query->distinct()->count('client_id');
        $totalReportTitles = $query->distinct()->count('audit_report_title');
        $totalRecurrence = $query->distinct()->where('recurrence', 'Yes')->count();

        // Recently updated counts (within the last day)
        $recentLeadBodies = $query->where('final_reports.created_at', '>=', Carbon::now()->subDay())->distinct()->count('final_reports.client_id');
        $recentReportTitles = $query->where('final_reports.created_at', '>=', Carbon::now()->subDay())->distinct()->count('final_reports.audit_report_title');
        $recentRecurrence = $query->where('final_reports.recurrence', 'Yes')->where('final_reports.created_at', '>=', Carbon::now()->subDay())->distinct()->count();
        $recentRecommendationsCount = $filteredRecommendations->where('final_reports.created_at', '>=', Carbon::now()->subDay())->count();


        $tool = Tool::first();

        // Define the directory path
        $directory = public_path('img/logo');
    
        // Get all files from the directory
        $files = glob($directory . '/*'); // Get all files in the directory
    
        if ($files) {
            // Find the most recently modified file
            $latestFile = array_reduce($files, function ($carry, $item) {
                return filemtime($carry) > filemtime($item) ? $carry : $item;
            });
    
            // Use basename to get the filename from the path
            $latestLogo = basename($latestFile);
        } else {
            // Fallback to a default image if no files are found
            $latestLogo = 'undppp.jpg'; // Ensure this is the default image you want to use
        }

        // Return the view with the calculated and filtered data
        return view('home', compact(
            'fullyImplementedCount',
            'partiallyImplementedCount',
            'notImplementedCount',
            'noupdateCount',
            'percent_fully_implemented',
            'percent_partially',
            'percent_not',
            'recentRecommendationsCount',
            'recentLeadBodies',
            'recentReportTitles',
            'tool',
            'latestLogo',
            'recentRecurrence',
            'percent_noupdate',
            'filteredRecommendations',
            'distinctReportTitles',
            'distinctLeadBodies',
            'totalLeadBodies',
            'totalReportTitles',
            'totalRecurrence',
            'selectedFilters',
            'filter_audit_report_title',
            'filter_country_office',
            'filter_start_date',
            'filter_end_date',
            'filter_recurrence',
            'totalRecommendationsCount',
            'distinctClientTypes',
            'distinctMainstreamGenders',
            'filter_audit_type',
            'filter_risk_level',

        ));
    }
}
