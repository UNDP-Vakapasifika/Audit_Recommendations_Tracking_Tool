<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FinalReportController;
use App\Mail\ConsolidatedActionPlanNotification;
use App\Models\ActionPlan;
use App\Models\Note;
use App\Models\AuditPractitioner;
use App\Models\FinalReport;
use App\Models\LeadBody;
use App\Models\MainstreamCategory;
use App\Models\Recommendation;
use App\Models\Stakeholder;
use App\Models\User;
use App\Notifications\ActionPlanSupervisedNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Psy\CodeCleaner\FinalClassPass;

class ActionPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view action plan'])->only(['index']);
        $this->middleware(['permission:create action plan'])->only(['create', 'store', 'store2', 'showActionPlanForm', 'storeActionPlan']);
        $this->middleware(['permission:supervise action plan'])->only(['SuperviseReportDetails', 'declinedactionsdetails', 'supervise', 'declinedactions']);
        $this->middleware(['permission:view action plan'])->only(['showReportDetails']);
        $this->middleware(['permission:edit action plan'])->only(['edit']);
        $this->middleware(['permission:view tracking tables'])->only(['tracking_index']);
    }

    public function index()
    {
        // Retrieve distinct report titles from Recommendations table based on recommendation IDs in ActionPlan table
        $uniqueReportTitles = ActionPlan::join('recommendations', 'action_plans.recommendation_id', '=', 'recommendations.id')
            ->distinct('recommendations.report_title')
            ->pluck('recommendations.report_title');
    
        $uniqueReportDetails = [];
    
        // Loop through each unique report title
        foreach ($uniqueReportTitles as $reportTitle) {
            // Retrieve the details for the first occurrence of the report title
            $reportDetails = ActionPlan::join('recommendations', 'action_plans.recommendation_id', '=', 'recommendations.id')
                ->where('recommendations.report_title', $reportTitle)
                ->first();
    
            // Fetch the country office name using its ID from the lead_bodies table
            $countryOfficeName = LeadBody::where('id', $reportDetails->country_office)->value('name');
    
            // Add the details to the array
            $uniqueReportDetails[] = [
                'id' => $reportDetails->id,
                'reportTitle' => $reportTitle,
                'countryOffice' => $countryOfficeName, // Use the fetched country office name
                'dateCreated' => $reportDetails->created_at->format('Y-m-d'),
                'createdPerson' => $reportDetails->created_person,
            ];
        }
    
        return view('action-plan.index', compact('uniqueReportDetails'));
    }


    public function supervise()
    {
        // Retrieve distinct report titles from Recommendations table using recommendation_ids in ActionPlan table
        $uniqueReportTitles = Recommendation::whereIn('id', function ($query) {
            $query->select('recommendation_id')->from('action_plans');
        })->distinct('report_title')->pluck('report_title');
    
        $uniqueReportDetails = [];
    
        // Loop through each unique report title
        foreach ($uniqueReportTitles as $reportTitle) {
            // Retrieve the first occurrence of the recommendation ID for the report title from ActionPlan table
            $recommendationId = ActionPlan::whereHas('recommendation', function ($query) use ($reportTitle) {
                $query->where('report_title', $reportTitle);
            })->pluck('recommendation_id')->first();
    
            // Retrieve the associated action plan details where supervised is null using the recommendation ID
            $actionPlan = ActionPlan::where('recommendation_id', $recommendationId)
                ->whereNull('supervised')
                ->first();
    
            if ($actionPlan) {
                // Retrieve the country office name using the country_office ID
                $countryOffice = LeadBody::find($actionPlan->country_office);
                $countryOfficeName = $countryOffice ? $countryOffice->name : 'Unknown';
    
                // Add the details to the array
                $uniqueReportDetails[] = [
                    'id' => $actionPlan->id,
                    'reportTitle' => $reportTitle,
                    'countryOffice' => $countryOfficeName,
                    'dateCreated' => $actionPlan->created_at->format('Y-m-d'),
                    'createdPerson' => $actionPlan->created_person,
                ];
            }
        }
    
        return view('actionplansupervise', compact('uniqueReportDetails'));
    }
    

    public function declinedactions()
    {
        // Retrieve distinct report titles from Recommendations table using recommendation_ids in ActionPlan table
        $uniqueReportTitles = Recommendation::whereIn('id', function ($query) {
            $query->select('recommendation_id')->from('action_plans');
        })->distinct('report_title')->pluck('report_title');
    
        $uniqueReportDetails = [];
    
        // Loop through each unique report title
        foreach ($uniqueReportTitles as $reportTitle) {
            // Retrieve the first occurrence of the recommendation ID for the report title from ActionPlan table
            $recommendationId = ActionPlan::whereHas('recommendation', function ($query) use ($reportTitle) {
                $query->where('report_title', $reportTitle);
            })->pluck('recommendation_id')->first();
    
            // Retrieve the associated action plan details where supervised is set to 0 using the recommendation ID
            $actionPlan = ActionPlan::where('recommendation_id', $recommendationId)
                ->where('supervised', 0)
                ->first();
    
            if ($actionPlan) {
                // Fetch the country office name from lead_bodies table
                $countryOffice = LeadBody::find($actionPlan->country_office);
    
                // Add the details to the array
                $uniqueReportDetails[] = [
                    'id' => $actionPlan->id,
                    'reportTitle' => $reportTitle,
                    'countryOffice' => $countryOffice ? $countryOffice->name : null,
                    'dateCreated' => $actionPlan->created_at->format('Y-m-d'),
                    'createdPerson' => $actionPlan->created_person,
                ];
            }
        }
    
        return view('actionplansdeclined', compact('uniqueReportDetails'));
    }

    public function create()
    {
        return view('action-plan.create');
    }

    public function store2(Request $request)
    {
        // Get the currently authenticated user's name
        $createdPerson = auth()->user()->name;

        // Validate the request data
        $validatedData = $request->validate([
            'country_office' => 'required',
            'date_of_audit' => 'required|date',
            'head_of_audited_entity' => 'required',
            'audited_entity_focal_point' => 'required',
            'audit_team_lead' => 'required',
            'audit_recommendations' => 'required',
            'audit_report_title' => 'required',
            'action_plan' => 'required',
            'current_implementation_status' => 'required',
            'target_completion_date' => 'required|date',
            'responsible_person' => 'required',
        ]);

        // Combine validated data with created_person
        $dataToInsert = array_merge($validatedData, ['created_person' => $createdPerson]);

        // Create the ActionPlan
        ActionPlan::create($dataToInsert);

        return redirect()->route('action-plans.index')->with('success', 'Action Plan created successfully.');
    }


    public function store(Request $request)
    {
        // Validation logic here, validate the $request data
        $validatedData = $request->validate([
            'country_office' => 'required',
            'date_of_audit' => 'required|date',
            'head_of_audited_entity' => 'required',
            'audited_entity_focal_point' => 'required',
            'audit_team_lead' => 'required',
            'responsible_person' => 'required',
            'recommendation_ids' => 'required|array',
            'recommendation_ids.*' => 'required|string',
            'current_implementation_status' => 'required|array',
            'current_implementation_status.*' => 'required|string',
            'classification' => 'required|array',
            'classification.*' => 'required|string',
            'action_plan' => 'required|array',
            'action_plan.*' => 'required|string',
            'target_completion_date' => 'required|array',
            'target_completion_date.*' => 'required|date',
            'audit_recommendations' => 'required|array',
            'audit_recommendations.*' => 'required|string',
            'gender_mainstream_type' => 'exists:mainstream_categories,id',
        ]);

        // dd($validatedData);
    
        // Separate arrays for dynamic data
        $recommendations = $validatedData['audit_recommendations'];
        $recommendation_ids = $validatedData['recommendation_ids'];
        $implementationStatuses = $validatedData['current_implementation_status'];
        $classfication = $validatedData['classification'];
        $actionPlans = $validatedData['action_plan'];
        $completionDates = $validatedData['target_completion_date'];
    
        // Get the currently authenticated user's name
        $createdPerson = auth()->user()->name;
        try {
            // Loop through each recommendation
            foreach ($recommendations as $key => $recommendation) {
                // Create an array for the data related to the current recommendation
                $data = [
                    'country_office' => $validatedData['country_office'],
                    'date_of_audit' => $validatedData['date_of_audit'],
                    'head_of_audited_entity' => $validatedData['head_of_audited_entity'],
                    'audited_entity_focal_point' => $validatedData['audited_entity_focal_point'],
                    'audit_team_lead' => $validatedData['audit_team_lead'],
                    'responsible_person' => $validatedData['responsible_person'],
                    'current_implementation_status' => $implementationStatuses[$key],
                    'classfication' => $classfication[$key],
                    'action_plan' => $actionPlans[$key],
                    'target_completion_date' => $completionDates[$key],
                    'created_person' => $createdPerson,
                    'recommendation_id' => $recommendation_ids[$key],
                    'category_type_id' => $validatedData['gender_mainstream_type'],
                ];
                
                // dd($data);
                // Insert data into the ActionPlan table
                ActionPlan::create($data);
            }
            return redirect()->route('action_plan1');
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
    
            if (strpos($errorMessage, 'Duplicate entry') !== false) {
                // Handle duplicate key error
                return redirect()->route('dynamicaction')->with('error', 'This record already exists.');
            } else {
                // Handle other general errors
                return redirect()->route('dynamicaction')->with('error', 'An error occurred: ' . $errorMessage);
            }
        }
    }
    

    public function showActionPlanForm()
    {
        // Retrieve distinct audit report titles from recommendations
        $auditTitles = Recommendation::distinct('report_title')->pluck('report_title');
    
        // Retrieve recommendations and their implementation status
        $recommendations = Recommendation::all(['id', 'report_title', 'recommendation', 'implementation_status']);
    
        // Retrieve data for options from audit_offices table
        $countryOffices = Stakeholder::where('name', 'like', 'SAI%')->pluck('name', 'id');
    
        $team_Leader = User::role('Team Leader')->pluck('name', 'id');
        $responsible_person = User::role('Internal Auditor')->pluck('name', 'id');
        $headOfEntities = User::role('Head of Audited Entity')->pluck('name', 'id');
        $focalPoint = User::role('Audited Entity Focal Point')->pluck('name', 'id');

        $genderMainstreamTypes = MainstreamCategory::pluck('name', 'id');

    
        $actionPlans = ActionPlan::orderBy('country_office')->get();
        $currentUser = Auth::user()->name;
    
        // Pass data to the view
        return view('action-plan.dynamic', compact('countryOffices','genderMainstreamTypes', 'actionPlans', 'currentUser', 'responsible_person', 'headOfEntities', 'recommendations', 'focalPoint', 'team_Leader', 'auditTitles'));
    }
    
    

    public function storeActionPlan(Request $request)
    {
        // Validate form data
        $validatedData = $request->validate([
            'recommendations.*.id' => 'required|exists:recommendations,id',
            'recommendations.*.action_plan' => 'required',
            'recommendations.*.completion_date' => 'required|date',
            'recommendations.*.implementation_status' => 'required',
        ]);

        // Loop through each recommendation the action plan table
        foreach ($validatedData as $data) {

            ActionPlan::create([
                'id' => $data['id'],
                'action_plan' => $data['action_plan'],
                'target_completion_date' => $data['completion_date'],
                'current_implementation_status' => $data['implementation_status'],
            ]);
        }

        return redirect()->route('show')->with('success', 'Action Plan created successfully.');
    }


    public function showForm()
    {
        // Retrieve data for options from audit_practitioners table
        $countryOffices = AuditPractitioner::distinct('audit_department')->pluck('audit_department');
        $headOfEntities = AuditPractitioner::where('role', 'internal_audit')->pluck('name');

        // Pass data to the view
        return view('action_plan_fina', compact('countryOffices', 'headOfEntities'));
    }

    public function getRecommendations($title)
    {
        // Fetch recommendations based on the selected title
        $recommendations = Recommendation::where('report_title', $title)->get(['recommendation', 'id']);

        return response()->json($recommendations);
    }


    public function showReportDetails($id)
    {
        // Retrieve the recommendation by ID
        $recommendation = Recommendation::findOrFail($id);
    
        // Extract the report title from the retrieved recommendation
        $reportTitle = $recommendation->report_title;
    
        // Fetch all recommendations with the same report title, selecting only the ID, report title, and recommendation text
        $relatedRecommendations = Recommendation::where('report_title', $reportTitle)
                                                ->get(['id', 'report_title', 'recommendation']);
    
        // Initialize an array to store the action plan details associated with each recommendation
        $reportDetails = [];
    
        // Iterate through each related recommendation to find its associated action plan details
        foreach ($relatedRecommendations as $relatedRecommendation) {
            // Find the action plan details by matching the recommendation ID with the recommendation_id column in the action plan table
            $actionPlan = ActionPlan::where('recommendation_id', $relatedRecommendation->id)->first();
    
            // If an action plan is found, add its details to the array
            if ($actionPlan) {
                $reportDetails[] = [
                    'id' => $actionPlan->id,
                    'report_title' => $relatedRecommendation->report_title,
                    'recommendation' => $relatedRecommendation->recommendation,
                    'country_office' => LeadBody::findOrFail($actionPlan->country_office)->name,
                    'current_implementation_status' => $actionPlan->current_implementation_status,
                    'classification' => $actionPlan->classfication,
                    'date_of_audit' => $actionPlan->date_of_audit,
                    'head_of_audited_entity' => User::findOrFail($actionPlan->head_of_audited_entity)->name,
                    'audited_entity_focal_point' => User::findOrFail($actionPlan->audited_entity_focal_point)->name,
                    'audit_team_lead' => User::findOrFail($actionPlan->audit_team_lead)->name,
                    'action_plan' => $actionPlan->action_plan,
                    'target_completion_date' => $actionPlan->target_completion_date,
                    'responsible_person' => User::findOrFail($actionPlan->responsible_person)->name,
                ];
            }
        }
    
        // Pass the action plan details to the view
        return view('action_plan_reports', compact('reportDetails'));
    }
    


    // public function SuperviseReportDetails($id)
    // {
    //     $actionPlan = ActionPlan::findOrFail($id);

    //     // Get the report title
    //     $reportTitle = $actionPlan->audit_report_title;

    //     // Query all records with the same report title
    //     $reportDetails = ActionPlan::where('audit_report_title', $reportTitle)
    //         ->where('supervised', Null)
    //         ->get();

    //     return view('actionplansupervisedetails', compact('reportDetails'));
    // }

    public function SuperviseReportDetails($id)
    {
        // Find the action plan by ID
        $actionPlan = ActionPlan::findOrFail($id);
    
        // Get the recommendation ID from the action plan
        $recommendationId = $actionPlan->recommendation_id;
    
        // Fetch the recommendation details using the recommendation ID
        $recommendation = Recommendation::findOrFail($recommendationId);
    
        // Get the report title from the recommendation
        $reportTitle = $recommendation->report_title;
    
        // Fetch all recommendations with the same report title
        $relatedRecommendations = Recommendation::where('report_title', $reportTitle)
            ->get(['id', 'report_title', 'recommendation']);
    
        // Initialize an array to store the action plan details associated with each recommendation
        $reportDetails = [];
    
        // Iterate through each related recommendation to find its associated action plan details
        foreach ($relatedRecommendations as $relatedRecommendation) {
            // Find the action plan details by matching the recommendation ID with the recommendation_id column in the action plan table
            $associatedActionPlan = ActionPlan::where('recommendation_id', $relatedRecommendation->id)
                ->where('supervised', null) // Filter by supervised status
                ->first();
    
            // If action plan details are found, add them to the array
            if ($associatedActionPlan) {
                // Fetch the user names for the IDs
                $headOfAuditedEntity = User::find($associatedActionPlan->head_of_audited_entity);
                $auditedEntityFocalPoint = User::find($associatedActionPlan->audited_entity_focal_point);
                $auditTeamLead = User::find($associatedActionPlan->audit_team_lead);
                $responsiblePerson = User::find($associatedActionPlan->responsible_person);
    
                // Add the details to the array
                $reportDetails[] = [
                    'id' => $associatedActionPlan->id,
                    'reportTitle' => $relatedRecommendation->report_title,
                    'recommendation' => $relatedRecommendation->recommendation,
                    'countryOffice' => $associatedActionPlan->country_office,
                    'currentImplementationStatus' => $associatedActionPlan->current_implementation_status,
                    'classification' => $associatedActionPlan->classfication,
                    'dateOfAudit' => $associatedActionPlan->date_of_audit,
                    'headOfAuditedEntity' => $headOfAuditedEntity ? $headOfAuditedEntity->name : null,
                    'auditedEntityFocalPoint' => $auditedEntityFocalPoint ? $auditedEntityFocalPoint->name : null,
                    'auditTeamLead' => $auditTeamLead ? $auditTeamLead->name : null,
                    'actionPlan' => $associatedActionPlan->action_plan,
                    'targetCompletionDate' => $associatedActionPlan->target_completion_date,
                    'responsiblePerson' => $responsiblePerson ? $responsiblePerson->name : null,
                ];
            }
        }
    
        // Pass the action plan details to the view
        return view('actionplansupervisedetails', compact('reportDetails'));
    }
    
    
    public function declinedactionsdetails($id)
    {
    // Find the action plan by ID
    $actionPlan = ActionPlan::findOrFail($id);

    // Get the recommendation ID from the action plan
    $recommendationId = $actionPlan->recommendation_id;

    // Fetch the recommendation details using the recommendation ID
    $recommendation = Recommendation::findOrFail($recommendationId);

    // Fetch all related recommendations with the same report title
    $relatedRecommendations = Recommendation::where('report_title', $recommendation->report_title)
        ->get(['id', 'report_title', 'recommendation']);

    // Initialize an array to store the action plan details associated with each recommendation
    $reportDetails = [];

    // Iterate through each related recommendation to find its associated action plan details
    foreach ($relatedRecommendations as $relatedRecommendation) {
        // Find the action plan details by matching the recommendation ID with the recommendation_id column in the action plan table
        $associatedActionPlan = ActionPlan::where('recommendation_id', $relatedRecommendation->id)
            ->where('supervised', null) // Filter by supervised status
            ->first();

        // If action plan details are found, add them to the array
        if ($associatedActionPlan) {
            // Fetch the user names for the IDs
            $headOfAuditedEntity = User::find($associatedActionPlan->head_of_audited_entity);
            $auditedEntityFocalPoint = User::find($associatedActionPlan->audited_entity_focal_point);
            $auditTeamLead = User::find($associatedActionPlan->audit_team_lead);
            $responsiblePerson = User::find($associatedActionPlan->responsible_person);

            // Fetch the country office name from lead_bodies table
            $countryOffice = LeadBody::find($associatedActionPlan->country_office);

            // Add the details to the array
            $reportDetails[] = [
                'id' => $associatedActionPlan->id,
                'reportTitle' => $relatedRecommendation->report_title,
                'countryOffice' => $countryOffice ? $countryOffice->name : null,
                'auditRecommendations' => $relatedRecommendation->recommendation,
                'currentImplementationStatus' => $associatedActionPlan->current_implementation_status,
                'classification' => $associatedActionPlan->classfication,
                'dateOfAudit' => $associatedActionPlan->date_of_audit,
                'headOfAuditedEntity' => $headOfAuditedEntity ? $headOfAuditedEntity->name : null,
                'auditedEntityFocalPoint' => $auditedEntityFocalPoint ? $auditedEntityFocalPoint->name : null,
                'auditTeamLead' => $auditTeamLead ? $auditTeamLead->name : null,
                'actionPlan' => $associatedActionPlan->action_plan,
                'targetCompletionDate' => $associatedActionPlan->target_completion_date,
                'responsiblePerson' => $responsiblePerson ? $responsiblePerson->name : null,
                'reason' => $associatedActionPlan->reason,
            ];
        }
    }
    
        // Pass the action plan details to the view
        return view('actionplansdeclineddetails', compact('reportDetails'));
    }
    

    public function updateactionplan(Request $request, $id)
    {
        $actionPlan = ActionPlan::findOrFail($id);
    
        $status = $request->input('status');
    
        if ($status === 'approved') {
            ActionPlan::where('id', $id)->update(['supervised' => 1]);
    
            // Create an instance of FinalReportController
            $finalReportController = new FinalReportController();
            $finalReportController->insertFinalReports();
    
            $responsible_person = User::find($actionPlan->responsible_person);
            if ($responsible_person) {
                $responsible_person->notify(new ActionPlanSupervisedNotification($actionPlan, $status));
            }
    
            $head_of_audited_entity = User::find($actionPlan->head_of_audited_entity);
            if ($head_of_audited_entity) {
                $head_of_audited_entity->notify(new ActionPlanSupervisedNotification($actionPlan, $status));
            }
    
            $audited_entity_focal_point = User::find($actionPlan->audited_entity_focal_point);
            if ($audited_entity_focal_point) {
                $audited_entity_focal_point->notify(new ActionPlanSupervisedNotification($actionPlan, $status));
            }
    
            $audit_team_lead = User::find($actionPlan->audit_team_lead);
            if ($audit_team_lead) {
                $audit_team_lead->notify(new ActionPlanSupervisedNotification($actionPlan, $status));
            }
    
            return redirect()->route('supervise');
        } elseif ($status === 'declined') {
            ActionPlan::where('id', $id)->update([
                'supervised' => 0,
                'reason' => $request->input('reason')
            ]);
    
            $responsible_person = User::find($actionPlan->responsible_person);
            if ($responsible_person) {
                $responsible_person->notify(new ActionPlanSupervisedNotification($actionPlan, $status));
            }
    
            $head_of_audited_entity = User::find($actionPlan->head_of_audited_entity);
            if ($head_of_audited_entity) {
                $head_of_audited_entity->notify(new ActionPlanSupervisedNotification($actionPlan, $status));
            }
    
            $audited_entity_focal_point = User::find($actionPlan->audited_entity_focal_point);
            if ($audited_entity_focal_point) {
                $audited_entity_focal_point->notify(new ActionPlanSupervisedNotification($actionPlan, $status));
            }
    
            $audit_team_lead = User::find($actionPlan->audit_team_lead);
            if ($audit_team_lead) {
                $audit_team_lead->notify(new ActionPlanSupervisedNotification($actionPlan, $status));
            }
        }
    
        // Redirect back or wherever you want
        return redirect()->route('supervise');
    }
    

    //For Action Plan Tracking
    public function tracking_index()
    {
        // Retrieve distinct report titles from Recommendations table using recommendation_ids in ActionPlan table
        $uniqueReportTitles = Recommendation::whereIn('id', function ($query) {
            $query->select('recommendation_id')->from('action_plans');
        })->distinct('report_title')->pluck('report_title');

        $uniqueReportDetails = [];

        // Loop through each unique report title
        foreach ($uniqueReportTitles as $reportTitle) {
            // Retrieve the first occurrence of the recommendation ID for the report title from ActionPlan table
            $recommendationId = ActionPlan::whereHas('recommendation', function ($query) use ($reportTitle) {
                $query->where('report_title', $reportTitle);
            })->pluck('recommendation_id')->first();

            // Retrieve the associated action plan details using the recommendation ID
            $actionPlan = ActionPlan::where('recommendation_id', $recommendationId)->first();

            if ($actionPlan) {
                // Add the details to the array
                $uniqueReportDetails[] = [
                    'id' => $actionPlan->id,
                    'reportTitle' => $reportTitle,
                    'countryOffice' => $actionPlan->country_office,
                    'dateCreated' => $actionPlan->created_at->format('Y-m-d'),
                    'createdPerson' => $actionPlan->created_person,
                ];
            }
        }

        $actionPlans = ActionPlan::whereDate('target_completion_date', '>', now())
            ->whereDate('target_completion_date', '<=', now()->addDays(30))
            ->get();

        // Calculate days remaining for each recommendation
        foreach ($actionPlans as $actionPlan) {
            $targetCompletionDate = Carbon::parse($actionPlan->target_completion_date);
            $daysRemaining = now()->diffInDays($targetCompletionDate);
            $actionPlan->days_remaining = $daysRemaining;
        }

        // Retrieve distinct report titles
        $uniqueReportTitles2 = FinalReport::distinct('audit_report_title')
            ->when(Auth::user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })
//            ->whereDate('target_completion_date', '>=', now())
            ->where('current_implementation_status', '!=', 'Fully Implemented')
            ->pluck('audit_report_title');
        // dd($uniqueReportTitles2);

        $uniqueReportDetails2 = [];

        // Loop through each unique report title
        foreach ($uniqueReportTitles2 as $reportTitle) {
            // Retrieve the details for the first occurrence of the report title, joining with LeadBody and User tables
            $reportDetails = FinalReport::where('audit_report_title', $reportTitle)
                ->with([
                    'leadBody' => function ($query) {
                        $query->select('id', 'name'); // Select lead body name
                    },
                    'headOfAuditedEntity' => function ($query) {
                        $query->select('id', 'name'); // Select head of audited entity name
                    },
                    'responsiblePerson' => function ($query) {
                        $query->select('id', 'name'); // Select responsible person name
                    },
                ])
                ->first();

            // Add the details to the array
            $uniqueReportDetails2[] = [
                'id' => $reportDetails->id,
                'reportTitle' => $reportTitle,
                'leadBody' => $reportDetails->leadBody ? $reportDetails->leadBody->name : null, // Retrieve lead body name
                'AuditedEntityHead' => $reportDetails->headOfAuditedEntity ? $reportDetails->headOfAuditedEntity->name : null, // Retrieve head of audited entity name
                'dateCreated' => $reportDetails->created_at->format('Y-m-d'),
                'createdPerson' => $reportDetails->responsiblePerson ? $reportDetails->responsiblePerson->name : null, // Retrieve responsible person name
            ];
        }


        $actionPlans2 = FinalReport::join('lead_bodies', 'final_reports.client_id', '=', 'lead_bodies.id')
            ->join('client_types', 'lead_bodies.client_type_id', '=', 'client_types.id')
            ->join('users', 'final_reports.sai_responsible_person_id', '=', 'users.id')
            ->whereDate('target_completion_date', '>=', now())
            ->whereDate('target_completion_date', '<=', now()->addDays(30))
            ->where('current_implementation_status', '!=', 'Fully Implemented')
            ->when(Auth::user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })
            ->select('final_reports.*', 'lead_bodies.name as client_name', 'client_types.name as client_type_name', 'users.name as responsible_person_name')
            ->get();

        // dd($actionPlans2);

        // Also join LeadBody and ClientType tables to fetch client names and client type names
        $actionPlans3 = FinalReport::join('lead_bodies', 'final_reports.client_id', '=', 'lead_bodies.id')
            ->join('client_types', 'lead_bodies.client_type_id', '=', 'client_types.id')
            ->join('users', 'final_reports.sai_responsible_person_id', '=', 'users.id')
            ->whereDate('target_completion_date', '<', now())
            ->where('current_implementation_status', '!=', 'Fully Implemented')
            ->when(Auth::user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })
            ->select('final_reports.*', 'lead_bodies.name as client_name', 'client_types.name as client_type_name', 'users.name as responsible_person_name')
            ->get();


        // Calculate due days for each recommendation for Final Report
        foreach ($actionPlans3 as $actionPlan) {
            $targetCompletionDate = Carbon::parse($actionPlan->target_completion_date);
            $daysRemaining = now()->diffInDays($targetCompletionDate);
            $actionPlan->days_remaining = $daysRemaining;
        }

        // Check if there are any near completion recommendations
        if ($actionPlans2->isEmpty() && $actionPlans3->isEmpty()) {
            $message = "No records currently";
            $totalNotes = Note::count();
            // return view('tracking', compact('message'));
            return view('tracking', compact('uniqueReportDetails', 'totalNotes','message', 'uniqueReportDetails2', 'actionPlans', 'actionPlans2', 'actionPlans3'));
        }

        // Retrieve final reports where the target completion date has passed
        // Retrieve final reports where the target completion date has passed and the current implementation status is not 'Fully Implemented'
        // Also join LeadBody and ClientType tables to fetch client names and client type names
        $actionPlans3 = FinalReport::join('lead_bodies', 'final_reports.client_id', '=', 'lead_bodies.id')
            ->join('client_types', 'lead_bodies.client_type_id', '=', 'client_types.id')
            ->join('users', 'final_reports.sai_responsible_person_id', '=', 'users.id')
            ->whereDate('target_completion_date', '<', now())
            ->where('current_implementation_status', '!=', 'Fully Implemented')
            ->when(Auth::user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })
            ->select('final_reports.*', 'lead_bodies.name as client_name', 'client_types.name as client_type_name', 'users.name as responsible_person_name')
            ->get();


        // Calculate days remaining for each recommendation
        foreach ($actionPlans2 as $actionPlan) {
            $targetCompletionDate = Carbon::parse($actionPlan->target_completion_date);
            $daysRemaining = now()->diffInDays($targetCompletionDate);
            $actionPlan->days_remaining = $daysRemaining;
        }

        // Calculate due days for each recommendation for Final Report
        foreach ($actionPlans3 as $actionPlan) {
            $targetCompletionDate = Carbon::parse($actionPlan->target_completion_date);
            $daysRemaining = now()->diffInDays($targetCompletionDate);
            $actionPlan->days_remaining = $daysRemaining;
        }

        $totalNotes = Note::count();
        // dd($totalNotes);

        return view('tracking', compact('uniqueReportDetails', 'totalNotes', 'uniqueReportDetails2', 'actionPlans', 'actionPlans2', 'actionPlans3'));
    }


    //Recom Tracking Detailss
    public function showReportDetails2($id)
    {
        $actionPlan = ActionPlan::findOrFail($id);

        $reportTitle = $actionPlan->audit_report_title;

        $reportDetails = ActionPlan::where('audit_report_title', $reportTitle)->get();

        // Calculate days remaining for each recommendation
        foreach ($reportDetails as $actionPlan) {
            $targetCompletionDate = Carbon::parse($actionPlan->target_completion_date);
            $daysRemaining = now()->diffInDays($targetCompletionDate);
            $actionPlan->days_remaining = $daysRemaining;
        }

        return view('tracking_details', compact('reportDetails'));
    }

    //Final report Recommendation Tracking Details
    public function showReportDetails3($id)
    {
        // Retrieve the final report by ID
        $actionPlan = FinalReport::findOrFail($id);

        // dd($actionPlan);
        // Retrieve all reports that share the same audit report title and join with ClientType
        $reportTitle = $actionPlan->audit_report_title;
        $reportDetails = FinalReport::where('audit_report_title', $reportTitle)
            ->where('current_implementation_status', '!=', 'Fully Implemented')
            ->join('client_types', 'final_reports.client_type_id', '=', 'client_types.id')
            ->select('final_reports.*', 'client_types.name as client_type_name')
            ->with([
                'leadBody' => function ($query) {
                    $query->select('id', 'name'); // Select lead body name
                },
                'responsiblePerson' => function ($query) {
                    $query->select('id', 'name'); // Select responsible person name
                },
                'headOfAuditedEntity' => function ($query) {
                    $query->select('id', 'name'); // Select head of audited entity name
                },
            ])
            ->get();
        
        // dd($reportDetails);
        // Loop through each report detail
        foreach ($reportDetails as $reportDetail) {
            // Parse the target completion date
            $targetCompletionDate = Carbon::parse($reportDetail->target_completion_date);

            // Calculate the difference in days between the current date and the target completion date
            $daysRemaining = now()->diffInDays($targetCompletionDate);

            // If the target completion date is in the past, negate the days remaining
            if ($targetCompletionDate->isPast()) {
                $daysRemaining *= -1;
            }

            // Assign the calculated days remaining value to the report detail
            $reportDetail->days_remaining = $daysRemaining;
        }

        // Return the view with the report details
        return view('tracking_details', compact('reportDetails'));
    }


    public function showReportDetailsView(int $id)
    {
        $finalReport = FinalReport::findOrFail($id);

        $finalReport->load('cautions.user');

        return view('tracking_details_view', compact('finalReport'));
    }

    public function showNearCompletionRecommendations()
    {
        // Get all action plans with less than 30 days remaining
        $actionPlans = FinalReport::whereDate('target_completion_date', '>', now())
            ->whereDate('target_completion_date', '<=', now()->addDays(30))
            ->get();

        // Calculate days remaining for each recommendation
        foreach ($actionPlans as $actionPlan) {
            $targetCompletionDate = Carbon::parse($actionPlan->target_completion_date);
            $daysRemaining = now()->diffInDays($targetCompletionDate);
            $actionPlan->days_remaining = $daysRemaining;
        }

        return view('near_completion_recommendations', compact('actionPlans'));
    }

    //Final emailing code
    public function sendConsolidatedEmailNotifications()
    {
        try {
            // Get all action plans with less than 30 days remaining
            $actionPlans = FinalReport::whereDate('target_completion_date', '>', now())
                ->whereDate('target_completion_date', '<=', now()->addDays(30))
                ->where('current_implementation_status', '!=', 'Fully Implemented')
                ->get();

            // Organize action plans by responsible person
            $actionPlansByPerson = $actionPlans->groupBy('responsible_person');

            // Loop through each responsible person
            foreach ($actionPlansByPerson as $responsiblePerson => $personActionPlans) {
                // Check if there are any action plans for this responsible person
                if (!$personActionPlans->isEmpty()) {
                    // Calculate days remaining for the first action plan
                    $targetCompletionDate = Carbon::parse($personActionPlans->first()->target_completion_date);
                    $daysRemaining = now()->diffInDays($targetCompletionDate);

                    // Define email intervals
                    $notificationIntervals = [30, 25, 20];

                    // Check if the current days remaining matches any notification interval
                    if (in_array($daysRemaining, $notificationIntervals) || ($daysRemaining <= 5 && $daysRemaining > 0)) {
                        // Get responsible person's email
                        $responsiblePersonEmail = $this->getResponsiblePersonEmail($responsiblePerson);

                        // If email found, send the consolidated notification
                        if ($responsiblePersonEmail) {
                            // Define custom message based on days remaining and count of recommendations
                            $customMessage = $this->getConsolidatedCustomMessage($daysRemaining, $personActionPlans->count());

                            // Send email
                            // Mail::to($responsiblePersonEmail)->send(new ConsolidatedActionPlanNotification($customMessage));
                            Mail::to($responsiblePersonEmail)->send(new ConsolidatedActionPlanNotification($customMessage, $responsiblePersonEmail));
                        } else {
                            Log::error("Email not found for responsible person: $responsiblePerson");
                        }
                    }
                }
            }
        } catch (Exception $e) {
            Log::error("Error in sendConsolidatedEmailNotifications: " . $e->getMessage());
        }
    }

    private function getResponsiblePersonEmail($name)
    {
        // Check AuditPractitioner table
        $auditPractitioner = AuditPractitioner::where('name', $name)->first();
        if ($auditPractitioner) {
            return $auditPractitioner->email;
        }

        // If not found, check FinalReport table
        $finalReport = FinalReport::where('responsible_person', $name)->first();
        if ($finalReport) {
            return $finalReport->responsible_person_email;
        }

        // If still not found, return null
        return null;
    }

    private function getConsolidatedCustomMessage($daysRemaining, $recommendationCount)
    {
        // Customize messages based on days remaining and count of recommendations
        return "You have {$recommendationCount} recommendations due in {$daysRemaining} days";
    }


    public function sendEmailNotifications()
    {
        try {
            // Call the method responsible for sending consolidated email notifications
            $this->sendConsolidatedEmailNotifications();

            return redirect()->back()->with('success', 'Email notifications sent successfully.');
        } catch (Exception $e) {
            Log::error("Error in sendEmailNotifications: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error sending email notifications.');
        }
    }


    public function edit($id)
    {
        $actionPlan = ActionPlan::findOrFail($id);
    
        // Fetch the names associated with the IDs
        $countryOffice = LeadBody::find($actionPlan->country_office);
        $countryOfficeName = $countryOffice ? $countryOffice->name : '';
    
        $headOfAuditedEntity = User::find($actionPlan->head_of_audited_entity);
        $headOfAuditedEntityName = $headOfAuditedEntity ? $headOfAuditedEntity->name : '';
    
        $auditedEntityFocalPoint = User::find($actionPlan->audited_entity_focal_point);
        $auditedEntityFocalPointName = $auditedEntityFocalPoint ? $auditedEntityFocalPoint->name : '';
    
        $auditTeamLead = User::find($actionPlan->audit_team_lead);
        $auditTeamLeadName = $auditTeamLead ? $auditTeamLead->name : '';
    
        $responsiblePerson = User::find($actionPlan->responsible_person);
        $responsiblePersonName = $responsiblePerson ? $responsiblePerson->name : '';
    
        // Fetch the recommendation and report title
        $recommendation = Recommendation::find($actionPlan->recommendation_id);
        $reportTitle = $recommendation ? $recommendation->report_title : '';
        $auditRecommendations = $recommendation ? $recommendation->recommendation : '';
    
        return view('action-plan.create', compact(
            'actionPlan',
            'countryOfficeName',
            'headOfAuditedEntityName',
            'auditedEntityFocalPointName',
            'auditTeamLeadName',
            'responsiblePersonName',
            'reportTitle',
            'auditRecommendations'
        ));
    }
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'country_office' => 'required',
            'date_of_audit' => 'required|date',
            'head_of_audited_entity' => 'required',
            'audited_entity_focal_point' => 'required',
            'audit_team_lead' => 'required',
            'audit_recommendations' => 'required',
            'audit_report_title' => 'required',
            'action_plan' => 'required',
            'current_implementation_status' => 'required',
            'target_completion_date' => 'required|date',
            'responsible_person' => 'required',
        ]);
    
        // Update the Action Plan record
        $actionPlan = ActionPlan::findOrFail($id);
        $actionPlan->supervised = null;
        $actionPlan->update($validatedData);
    
        return redirect()->route('action-plans.index');
    }
   
    public function getModel()
    {
        return new ActionPlan();
    }
}
