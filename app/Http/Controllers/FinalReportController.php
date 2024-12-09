<?php

namespace App\Http\Controllers;

use App\Models\ActionPlan;
use App\Models\FinalReport;
use App\Models\User;
use App\Models\Note;
use App\Models\Caution;
use App\Models\MainstreamCategory;
use App\Models\ClientType;
use App\Models\NoteReply;
use App\Models\Conversation;
use App\Models\LeadBody;
use App\Models\Recommendation;
use App\Models\ImplementationStatusChange;
// use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Auth;
// use function Spatie\LaravelPdf\Support\pdf;


class FinalReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:change final report status')->only('showFinalReportDetails', 'editFinalReports', 'editstatus');
        $this->middleware('permission:view final report')->only('showFinalReports');
    }

    // Final report recommendation tracking details
    public function showFinalReportDetails($id)
    {
        // Retrieve the specific FinalReport by ID
        $actionPlan = FinalReport::findOrFail($id);

        // Retrieve all reports that share the same audit report title
        $reportTitle = $actionPlan->audit_report_title;
        $reportDetails = FinalReport::where('audit_report_title', $reportTitle)
            ->with('countryOffice')
            ->get();

        // Loop through each report detail
        foreach ($reportDetails as $reportDetail) {
            // Parse the target completion date
            $targetCompletionDate = Carbon::parse($reportDetail->target_completion_date);

            // Calculate the difference in days between the target completion date and the current date
            $daysRemaining = now()->diffInDays($targetCompletionDate);

            // If the target completion date is in the past, make the days remaining negative
            if ($targetCompletionDate->isPast()) {
                $daysRemaining *= -1;
            }

            // Assign the calculated days remaining value to the report detail
            $reportDetail->days_remaining = $daysRemaining;

            // Retrieve the responsible person ID
            $responsiblePersonId = $reportDetail->sai_responsible_person_id;

            // Query the User model to get the responsible person's name
            $responsiblePersonName = User::where('id', $responsiblePersonId)->value('name');

            // Add the responsible person's name to the report detail
            $reportDetail->responsible_person_name = $responsiblePersonName;
        }

        // Return the view with the report details
        return view('final_report_edit_details', compact('reportDetails'));
    }

    // public function showFinalReportDetails($id, $status)
    // {
    //     // Retrieve the specific FinalReport by ID
    //     $actionPlan = FinalReport::findOrFail($id);

    //     // Retrieve the implementation status based on the passed status parameter
    //     $statusMapping = [
    //         'fully_implemented' => 'Fully Implemented',
    //         'partly_implemented' => 'Partially Implemented',
    //         'not_implemented' => 'Not Implemented',
    //         'noupdate_implementation' => 'No Update',
    //         'no_longer_applicable' => 'No Longer Applicable',
    //     ];

    //     $implementationStatus = $statusMapping[$status] ?? null;

    //     // Retrieve all reports that share the same audit report title and filter by implementation status
    //     $reportTitle = $actionPlan->audit_report_title;
    //     $query = FinalReport::where('audit_report_title', $reportTitle);

    //     if ($implementationStatus) {
    //         $query->where('current_implementation_status', $implementationStatus);
    //     }

    //     $reportDetails = $query->with('countryOffice')->get();

    //     // Loop through each report detail
    //     foreach ($reportDetails as $reportDetail) {
    //         // Parse the target completion date
    //         $targetCompletionDate = Carbon::parse($reportDetail->target_completion_date);

    //         // Calculate the difference in days between the target completion date and the current date
    //         $daysRemaining = now()->diffInDays($targetCompletionDate);

    //         // If the target completion date is in the past, make the days remaining negative
    //         if ($targetCompletionDate->isPast()) {
    //             $daysRemaining *= -1;
    //         }

    //         // Assign the calculated days remaining value to the report detail
    //         $reportDetail->days_remaining = $daysRemaining;

    //         // Retrieve the responsible person ID
    //         $responsiblePersonId = $reportDetail->sai_responsible_person_id;

    //         // Query the User model to get the responsible person's name
    //         $responsiblePersonName = User::where('id', $responsiblePersonId)->value('name');

    //         // Add the responsible person's name to the report detail
    //         $reportDetail->responsible_person_name = $responsiblePersonName;
    //     }

    //     // Return the view with the report details
    //     return view('final_report_edit_details', compact('reportDetails'));
    // }

    public function editFinalReports()
    {
        // Retrieve distinct report titles where the current implementation status is not 'Fully Implemented'
        $uniqueReportTitles2 = FinalReport::where('current_implementation_status', '!=', 'Fully Implemented')
            ->distinct()
            ->pluck('audit_report_title');

        // Initialize an array to store unique report details
        $uniqueReportDetails2 = [];

        // Loop through each unique report title
        foreach ($uniqueReportTitles2 as $reportTitle) {
            // Retrieve the first occurrence of the report title with eager loading for lead body and responsible person
            $reportDetails = FinalReport::where('audit_report_title', $reportTitle)
                ->select('id', 'audit_report_title', 'client_id', 'sai_responsible_person_id', 'created_at')
                ->first();

            // If a report detail is found
            if ($reportDetails) {
                // Retrieve the client ID and responsible person ID
                $clientId = $reportDetails->client_id;
                $responsiblePersonId = $reportDetails->sai_responsible_person_id;

                // Query the LeadBody table using the client ID to retrieve the name of the lead body
                $leadBodyName = LeadBody::where('id', $clientId)->value('name');

                // Query the User table using the responsible person ID to retrieve the name of the responsible person
                $responsiblePersonName = User::where('id', $responsiblePersonId)->value('name');

                // Add the report details and retrieved names to the array
                $uniqueReportDetails2[] = [
                    'id' => $reportDetails->id,
                    'reportTitle' => $reportTitle,
                    'client' => $leadBodyName,
                    'dateCreated' => $reportDetails->created_at->format('Y-m-d'),
                    'sai_responsible_person' => $responsiblePersonName,
                ];
            }
        }

        // dd($uniqueReportDetails2);

        $actionPlans2 = FinalReport::whereDate('target_completion_date', '>', now())
            ->whereDate('target_completion_date', '<=', now()->addDays(30))
            ->where('current_implementation_status', '!=', 'Fully Implemented')
            ->get();


        // Check if there are any near completion recommendations
        if ($actionPlans2->isEmpty()) {
            $message = "No records currently";
            // return view('tracking', compact('message'));
            return view('final_report_edit', compact('message', 'uniqueReportDetails2'));
        }

        return view('final_report_edit', compact('uniqueReportDetails2'));
    }

    //Edit the action Plan
    public function editstatus($id)
    {
        $finalReport = FinalReport::findOrFail($id);

        return view('final_report_editing', compact('finalReport'));
    }

    // public function updateStatus(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'audit_recommendations' => 'required',
    //         'audit_report_title' => 'required',
    //         'current_implementation_status' => 'required',
    //         'target_completion_date' => 'required|date',
    //         'evidence' => 'nullable|file|mimes:pdf,doc,docx',
    //         'impact' => 'nullable|file|mimes:pdf,doc,docx',
    //     ]);

    //     // Get the current status and date before updating
    //     $finalReport = FinalReport::findOrFail($id);
    //     $fromStatus = $finalReport->current_implementation_status;
    //     $fromDate = $finalReport->target_completion_date;

    //     // dd($fromDate);
    //     // Update the final_reports table
    //     $finalReport->update($validatedData);

    //     // Save files
    //     // $evidencePath = $request->hasFile('evidence') ? $request->file('evidence')->store('evidence') : null;
    //     // $impactPath = $request->hasFile('impact') ? $request->file('impact')->store('impact') : null;

    //     // Save files with meaningful names
    //     $evidencePath = $request->hasFile('evidence') 
    //         ? $request->file('evidence')->storeAs('public/evidence', time() . '-' . $request->file('evidence')->getClientOriginalName()) 
    //         : null;
    //     $impactPath = $request->hasFile('impact') 
    //         ? $request->file('impact')->storeAs('public/impact', time() . '-' . $request->file('impact')->getClientOriginalName()) 
    //         : null;
    //     // Insert into implementation_status_changes table
    //     ImplementationStatusChange::create([
    //         'final_report_id' => $id,
    //         'from_status' => $fromStatus,
    //         'to_status' => $request->current_implementation_status,
    //         'from_date' => $fromDate,
    //         'to_date' => $request->target_completion_date,
    //         'evidence' => $evidencePath,
    //         'impact' => $impactPath,
    //         'changed_by' => auth()->id(),

    //     ]);

    //     return redirect()->route('edit.finalreport')->with('success', 'Status updated successfully.');
    // }

    public function updateStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'audit_recommendations' => 'required',
            'audit_report_title' => 'required',
            'current_implementation_status' => 'required',
            'target_completion_date' => 'required|date',
            'evidence' => 'nullable|file|mimes:pdf,doc,docx',
            'impact' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        // Get the current status and date before updating
        $finalReport = FinalReport::findOrFail($id);
        $fromStatus = $finalReport->current_implementation_status;
        $fromDate = $finalReport->target_completion_date;

        // Update the final_reports table
        $finalReport->update($validatedData);

        // Save files with meaningful names directly to the public directory
        $evidencePath = $request->hasFile('evidence') 
            ? 'evidence/' . time() . '-' . $request->file('evidence')->getClientOriginalName() 
            : null;

        $impactPath = $request->hasFile('impact') 
            ? 'impact/' . time() . '-' . $request->file('impact')->getClientOriginalName() 
            : null;

        if ($evidencePath) {
            $request->file('evidence')->move(public_path('evidence'), $evidencePath);
        }

        if ($impactPath) {
            $request->file('impact')->move(public_path('impact'), $impactPath);
        }

        // Insert into implementation_status_changes table
        ImplementationStatusChange::create([
            'final_report_id' => $id,
            'from_status' => $fromStatus,
            'to_status' => $request->current_implementation_status,
            'from_date' => $fromDate,
            'to_date' => $request->target_completion_date,
            'evidence' => $evidencePath,
            'impact' => $impactPath,
            'changed_by' => auth()->id(),
        ]);

        return redirect()->route('edit.finalreport')->with('success', 'Status updated successfully.');
    }


    public function changeStatusSummary()
    {
        $changes = ImplementationStatusChange::with(['finalReport', 'user'])
            ->get();

        return view('final_report_status_change_summary', compact('changes'));
    }



    // Show final report table
    public function showFinalReports()
    {
        // Query records from the final report table with eager loading of related data
        $finalReports = FinalReport::with([

            'leadBody' => function ($query) {
                $query->select('id', 'name'); // Select only the id and name fields
            },

            'clientType' => function ($query) {
                $query->select('id', 'name'); // Select only the id and name fields
            },

            'mainstreamCategory' => function ($query) {
                $query->select('id', 'name'); // Select only the id and name fields
            },

            'saiResponsiblePerson' => function ($query) {
                $query->select('id', 'name'); // Select only the id and name fields
            },
            'headOfAuditedEntity' => function ($query) {
                $query->select('id', 'name'); // Select only the id and name fields
            },
            'auditedEntityFocalPoint' => function ($query) {
                $query->select('id', 'name'); // Select only the id and name fields
            },
            'auditTeamLead' => function ($query) {
                $query->select('id', 'name'); // Select only the id and name fields
            }
        ])->when(Auth::user()->hasRole('Client'), function ($query) {
            $query->where('client_id', auth()->user()->lead_body_id);
        })->get();

        // Return the view with the final report details
        return view('reports.final_report', compact('finalReports'));
        }
        
        public function edit($id)
        {
            $finalReport = FinalReport::findOrFail($id);
        
            // Get the data for dropdown fields
            $classificationOptions = ['High', 'Medium', 'Low'];
            $implementationStatusOptions = [
                'Fully Implemented', 
                'Not Implemented', 
                'Partially Implemented', 
                'No Update'
            ];

            // dd($finalReport);
        
            return view('reports.final_report_edit', compact(
                'finalReport', 
                'classificationOptions', 
                'implementationStatusOptions'
            ));
        }
      
        
        public function update(Request $request, $id)
        {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'audit_report_title' => 'required|string|max:255',
                'date_of_audit' => 'required|date',
                'publication_date' => 'required|date',
                'page_par_reference' => 'required|string|max:255',
                'audit_recommendations' => 'required|string',
                'classification' => 'required|in:High,Medium,Low', // Validation for classification
                'target_completion_date' => 'required|date',
                'follow_up_date' => 'required|date',
                'action_plan' => 'required|string',
                // 'sai_confirmation' => 'nullable|string|max:255',
                'summary_of_response' => 'nullable|string',
                'current_implementation_status' => 'required|in:Fully Implemented,Not Implemented,Partially Implemented,No Update' // Validation for implementation status
            ]);
        
            // Find the final report by ID
            $finalReport = FinalReport::findOrFail($id);
        
            // Update the final report fields
            $finalReport->audit_report_title = $validatedData['audit_report_title'];
            $finalReport->date_of_audit = $validatedData['date_of_audit'];
            $finalReport->publication_date = $validatedData['publication_date'];
            $finalReport->page_par_reference = $validatedData['page_par_reference'];
            $finalReport->audit_recommendations = $validatedData['audit_recommendations'];
            $finalReport->classification = $validatedData['classification'];
            $finalReport->target_completion_date = $validatedData['target_completion_date'];
            $finalReport->follow_up_date = $validatedData['follow_up_date'];
            $finalReport->action_plan = $validatedData['action_plan'];
            // $finalReport->sai_confirmation = $validatedData['sai_confirmation'];
            $finalReport->summary_of_response = $validatedData['summary_of_response'];
            $finalReport->current_implementation_status = $validatedData['current_implementation_status'];
        
            // Save the updated final report
            $finalReport->save();
        
            // Redirect back with a success message
            return redirect()->route('finalreport')
                ->with('success', 'Final report updated successfully.');
        }
        
        

        public function showUnimplementedReports()
        {
            // Query records from the final report table with eager loading of related data
            $unimplementedReports = FinalReport::with([
                'leadBody' => function ($query) {
                    $query->select('id', 'name'); // Select only the id and name fields
                },
                'clientType' => function ($query) {
                    $query->select('id', 'name'); // Select only the id and name fields
                },
                'mainstreamCategory' => function ($query) {
                    $query->select('id', 'name'); // Select only the id and name fields
                },
                'saiResponsiblePerson' => function ($query) {
                    $query->select('id', 'name'); // Select only the id and name fields
                },
                'headOfAuditedEntity' => function ($query) {
                    $query->select('id', 'name'); // Select only the id and name fields
                },
                'auditedEntityFocalPoint' => function ($query) {
                    $query->select('id', 'name'); // Select only the id and name fields
                },
                'auditTeamLead' => function ($query) {
                    $query->select('id', 'name'); // Select only the id and name fields
                }
            ])->where('current_implementation_status', '!=', 'Fully Implemented') // Filter by implementation status
            ->when(Auth::user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })->get();
        
            // Return the view with the final report details
            return view('reports.unimplemented_report', compact('unimplementedReports'));
        }
    


    public function insertFinalReports()
    {
        // Retrieve all action plans
        $actionPlans = ActionPlan::all();

        // Iterate over each action plan
        foreach ($actionPlans as $actionPlan) {
            // Retrieve recommendation ID from the action plan
            $recommendationId = $actionPlan->recommendation_id;

            // Fetch recommendation details using recommendation ID
            $recommendation = Recommendation::findOrFail($recommendationId);

            // Find the head of audited entity
            $headOfAuditedEntity = User::findOrFail($actionPlan->head_of_audited_entity);

            // Retrieve the lead body ID of the head of audited entity
            $leadBodyId = $headOfAuditedEntity->lead_body_id;

            // Find the corresponding client type ID in the lead bodies table
            $leadBody = LeadBody::findOrFail($leadBodyId);
            $clientTypeId = $leadBody->client_type_id;

            $finalReport = FinalReport::where('audit_recommendations', $recommendation->recommendation)->first();

            // Prepare attributes for final report
            $finalReportAttributes = [
                'country_office' => $actionPlan->country_office,
                'audit_report_title' => $recommendation->report_title,
                'audit_type' => $recommendation->audit_type,
                'date_of_audit' => $actionPlan->date_of_audit,
                'publication_date' => $recommendation->publication_date,
                'page_par_reference' => $recommendation->page_par_reference,
                'audit_recommendations' => $recommendation->recommendation,
                'classification' => $actionPlan->classfication, // Updated field name
                'client' => $recommendation->client,
                'key_issues' => $recommendation->key_issues,
                'acceptance_status' => $recommendation->acceptance_status,
                'current_implementation_status' => $actionPlan->current_implementation_status,
                'target_completion_date' => $actionPlan->target_completion_date,
                'recurrence' => $recommendation->recurrence,
                'follow_up_date' => $recommendation->follow_up_date,
                'action_plan' => $actionPlan->action_plan,
                'sai_responsible_person_id' => $actionPlan->responsible_person,
                'mainstream_categories_id' => $actionPlan->category_type_id,
                'client_id' => $leadBodyId,
                'client_type_id' => $clientTypeId,
                'head_of_audited_entity_id' => $actionPlan->head_of_audited_entity,
                'audited_entity_focal_point_id' => $actionPlan->audited_entity_focal_point,
                'audit_team_lead_id' => $actionPlan->audit_team_lead,
                'summary_of_response' => $recommendation->summary_of_response,
            ];

            // dd($finalReportAttributes);

            // If final report exists, update the record; otherwise, create a new record
            if ($finalReport) {
                $finalReport->update($finalReportAttributes);
            } else {
                FinalReport::create($finalReportAttributes);
            }
        }

        return redirect()->back();
    }


    public function generatePdf()
    {
        // Get unique report titles with recommendations not fully implemented
        $uniqueReportTitles = DB::table('final_reports')
            ->where('current_implementation_status', '!=', 'Fully Implemented')
            ->distinct('audit_report_title')
            ->pluck('audit_report_title');

        $uniqueReportTitles2 = DB::table('final_reports')
        ->distinct('audit_report_title')
        ->pluck('audit_report_title');

        // Get details for each report and its recommendations
        $reportDetails = [];
        foreach ($uniqueReportTitles as $reportTitle) {
            $recommendations = DB::table('final_reports')
                ->where('audit_report_title', $reportTitle)
                ->where('current_implementation_status', '!=', 'Fully Implemented')
                ->get();

            // Add report details to the array
            $reportDetails[] = [
                'reportTitle' => $reportTitle,
                'recommendations' => $recommendations,
            ];
        }
        // Get unique report titles with unresolved recommendations
        $unresolvedReports = DB::table('final_reports')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('final_reports as fr2')
                    ->whereRaw('final_reports.audit_report_title = fr2.audit_report_title')
                    ->where('fr2.current_implementation_status', '=', 'Fully Implemented');
            })
            ->select('audit_report_title', 'publication_date', 'acceptance_status as response_received')
            ->distinct('audit_report_title')
            ->get();

        // For each unique report, count the number of unresolved recommendations
        foreach ($unresolvedReports as $report) {
            $report->unresolved_count = DB::table('final_reports')
                ->where('audit_report_title', $report->audit_report_title)
                ->where('current_implementation_status', '!=', 'Fully Implemented')
                ->count();
        }

        // Get overall summary data
        $totalReports = count($uniqueReportTitles2);

        $totalRecommendations = DB::table('final_reports')->count();

        $fullyImplementedCount = DB::table('final_reports')
            ->where('current_implementation_status', 'Fully Implemented')
            ->count();

        $inProgressCount = DB::table('final_reports')
            ->where('current_implementation_status', 'No Update')
            ->count();

        $unimplementedCount = DB::table('final_reports')
            ->where('current_implementation_status', 'Not Implemented')
            ->count();

        $partiallyRealizedCount = DB::table('final_reports')
            ->where('current_implementation_status', 'Partially Implemented')
            ->count();
        
        // Pass data to the view
        $data = [
            'reportDetails' => $reportDetails,
            'unresolvedReports' => $unresolvedReports,
            'totalReports' => $totalReports,
            'totalRecommendations' => $totalRecommendations,
            'fullyImplementedCount' => $fullyImplementedCount,
            'inProgressCount' => $inProgressCount,
            'unimplementedCount' => $unimplementedCount,
            'partiallyRealizedCount' => $partiallyRealizedCount,
        ];

        // Generate PDF without triggering download
        $pdf = PDF::loadView('report', $data);

        // Get the raw PDF content
        $pdfContent = $pdf->output();

        // Set the content type
        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        // Return the PDF as a response without triggering download
        return response($pdfContent, 200, $headers);
    }


        /**
     * Show the preview of the CSV data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function showPreview(Request $request)
    {
        // Assume the parsed CSV data is stored in a session or request
        $data = session('parsedCSVData');

        // Fetch data for dropdowns from the database
        $clients = Client::all();
        $clientTypes = ClientType::all();
        $personnel = Personnel::all();
        $entities = Entity::all();
        $auditTeamLeads = AuditTeamLead::all();
        $focalPoints = FocalPoint::all();

        // Pass the data and dropdown options to the preview view
        return view('final_report_preview.index', compact(
            'data',
            'clients',
            'clientTypes',
            'personnel',
            'entities',
            'auditTeamLeads',
            'focalPoints'
        ));
    }

    /**
     * Confirm and save the final report data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(Request $request)
    {
        dd($request->all());
        // Retrieve the user's selections from the request
        $data = session('parsedCSVData');
        $responsiblePersons = $request->input('responsible_person');
        $responsibleEntities = $request->input('responsible_entity');
        $headOfAuditedEntities = $request->input('head_of_audited_entity');
        $auditedEntityFocalPoints = $request->input('audited_entity_focal_point');
        $auditTeamLeads = $request->input('audit_team_lead');
        $responsiblePersonEmails = $request->input('responsible_person_email');

        try {
            // Process and save the final report data
            foreach ($data as $index => $row) {
                FinalReport::create([
                    'country_office' => $row[0],
                    'audit_report_title' => $row[1],
                    'audit_type' => $row[2],
                    'date_of_audit' => $row[3],
                    'publication_date' => $row[4],
                    'page_par_reference' => $row[5],
                    'audit_recommendations' => $row[6],
                    'classfication' => $row[7],
                    'client_id' => $clients[$index],  // Associate client
                    'client_type_id' => $clientTypes[$index],  // Associate client type
                    'key_issues' => $row[10],
                    'acceptance_status' => $row[11],
                    'current_implementation_status' => $row[12],
                    'reason_not_implemented' => $row[13],
                    'follow_up_date' => $row[14],
                    'target_completion_date' => $row[15],
                    'recurence' => $row[16],
                    'action_plan' => $row[17],
                    'responsible_person_id' => $responsiblePersons[$index],  // Associate responsible person
                    'acceptance_status' => $row[19],
                    'responsible_entity_id' => $responsibleEntities[$index],  // Associate responsible entity
                    'head_of_audited_entity_id' => $headOfAuditedEntities[$index],  // Associate head of audited entity
                    'audited_entity_focal_point_id' => $auditedEntityFocalPoints[$index],  // Associate audited entity focal point
                    'audit_team_lead_id' => $auditTeamLeads[$index],  // Associate audit team lead
                    'summary_of_response' => $row[24],
                    'responsible_person_email_id' => $responsiblePersonEmails[$index],  // Associate responsible person email
                ]);
            }

            // Redirect to a success page or another appropriate route
            return redirect()->route('tracking_page')->with('success', 'Final report data saved successfully.');

        } catch (\Exception $e) {
            // Handle any exceptions and redirect back with an error message
            return redirect()->route('tracking_page')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $recommendation = FinalReport::findOrFail($id);
    
        // Retrieve related records
        $notes = Note::where('final_report_id', $recommendation->final_report_id)->get();
        $conversations = Conversation::where('final_report_id', $recommendation->final_report_id)->get();
        $cautions = Caution::where('final_report_id', $recommendation->final_report_id)->get();
    
        // Delete related notes and their replies
        foreach ($notes as $note) {
            $noteReplies = NoteReply::where('note_id', $note->id)->get();
            foreach ($noteReplies as $noteReply) {
                $noteReply->delete();
            }
            $note->delete();
        }
    
        // Delete related conversations
        foreach ($conversations as $conversation) {
            $conversation->delete();
        }
    
        // Delete related cautions
        foreach ($cautions as $caution) {
            $caution->delete();
        }
    
        // Finally, delete the recommendation
        $recommendation->delete();
    
        return redirect()->back()->with('success', 'Recommendation and related records deleted successfully.');
    }
    


    public function getModel()
    {
        return new FinalReport();
    }
}
