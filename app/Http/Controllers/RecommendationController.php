<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRecommendationRequest;
use App\Models\FinalReport;
use App\Models\User;
use App\Models\LeadBody;
use App\Models\ClientType;
use App\Models\MainstreamCategory;
use App\Models\Recommendation;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Carbon\Carbon;



class RecommendationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:edit recommendations')->only(['edit', 'update']);
        $this->middleware('permission:view recommendations')->only(['index', 'show']);
        $this->middleware('permission:delete recommendations')->only(['destroy']);
        $this->middleware('permission:upload recommendations')->only(['uploadRecommendations', 'create', 'store']);
    }

    // public function index(): View
    // {
    //     if(auth()->user()->hasRole('Client')) {
    //         $recommendations = Recommendation::where('Client', auth()->user()->lead_body_id)->get();
    //     } else {
    //         $recommendations = Recommendation::all();
    //     }

    //     return view('recommendations.index', compact('recommendations'));
    // }

    public function index(): View
    {
        // Define the base query for unique reports
        $baseQuery = Recommendation::select(
            'report_title',
            'audit_type',
            'publication_date',
            'client',
            'responsible_entity'
        )
        ->groupBy('report_title', 'audit_type', 'publication_date', 'client', 'responsible_entity')
        ->selectRaw('MIN(id) as min_id'); // Select the first occurrence to avoid duplicates later
    
        if (auth()->user()->hasRole('Client')) {
            $baseQuery->where('client', auth()->user()->lead_body_id);
        }
    
        // Get all unique reports based on grouping fields
        $uniqueReports = $baseQuery->get()->unique('report_title');
    
        // Iterate through each unique report to get the recommendation count
        $recommendations = $uniqueReports->map(function ($item) {
            // Count the number of recommendations per report title
            $item->recommendation_count = Recommendation::where('report_title', $item->report_title)->count();
    
            // Convert publication_date to Carbon instance
            $item->publication_date = Carbon::parse($item->publication_date);
            
            // Check if client field is numeric and fetch name from lead_bodies table
            if (is_numeric($item->client)) {
                $leadBody = LeadBody::find($item->client);
                $item->client = $leadBody ? $leadBody->name : $item->client; // Use the name if found, otherwise keep the ID
            }
    
            return $item;
        });
    
        return view('recommendations.index', compact('recommendations'));
    }
    

    public function showDetails(string $report_title): View
    {
        // Fetch all recommendations for the specific report title
        $recommendations = Recommendation::where('report_title', $report_title)->get();
    
        // Ensure that if no recommendations are found, an empty collection is passed
        if ($recommendations->isEmpty()) {
            abort(404, 'No recommendations found for this report.');
        }
    
        // Process each recommendation to check and possibly convert client ID to name
        $recommendations->transform(function ($item) {
            // Check if client field is numeric and fetch name from lead_bodies table
            if (is_numeric($item->client)) {
                $leadBody = LeadBody::find($item->client);
                $item->client = $leadBody ? $leadBody->name : $item->client; // Use the name if found, otherwise keep the ID
            }
    
            return $item;
        });
    
        // Pass the first recommendation's details for the page heading
        $firstRecommendation = $recommendations->first();
    
        return view('recommendations.show', compact('recommendations', 'firstRecommendation'));
    }
    
    
    public function create(): View
    {
        $clients = LeadBody::all();

        return view('recommendations.create', compact(
            'clients'
        ));
    }

    public function edit(Recommendation $recommendation): View
    {
        $this->checkPermission($recommendation);

        $clients = LeadBody::all();

        return view('recommendations.create', compact('recommendation', 'clients'));
    }

    public function update(CreateRecommendationRequest $request, Recommendation $recommendation)
    {
        $this->checkPermission($recommendation);

        $recommendation->update($request->validated());

        return redirect()->route('recommendations.index')->with('success', 'Recommendation updated successfully.');
    }

    // public function show(Recommendation $recommendation): View
    // {
    //     $this->checkPermission($recommendation);

    //     $recommendation->load('auditedClient');

    //     return view('recommendations.show', compact('recommendation'));
    // }

    public function show(Recommendation $recommendation): View
    {
        $this->checkPermission($recommendation);

        // Load related data
        $recommendation->load('auditedClient');

        // Fetch all recommendations for the specific report title
        $recommendations = Recommendation::where('report_title', $recommendation->report_title)->get();

        return view('recommendations.show', compact('recommendation', 'recommendations'));
    }

    public function destroy(Recommendation $recommendation)
    {
        $this->checkPermission($recommendation);
    
        $recommendation->delete();
    
        return redirect()->route('recommendations.index')->with('success', 'Recommendation deleted successfully.');
    }

    public function delete($id)
    {
        $recommendation = Recommendation::findOrFail($id);
        
        $this->checkPermission($recommendation);

        $recommendation->delete();

        return redirect()->route('recommendations.index')->with('success', 'Recommendation deleted successfully.');
    }

    

    public function store(CreateRecommendationRequest $request)
    {
        Recommendation::create($request->validated());

        return redirect()->route('recommendations.index')->with('success', 'Recommendation created successfully.');
    }

    // For excel upload
    public function uploadRecommendations(Request $request)
    {
        // Check if a file was uploaded
        if ($request->hasFile('excelDoc')) {
            $file = $request->file('excelDoc');

            // Check if the file is a CSV file
            if ($file->getClientOriginalExtension() === 'csv') {

                $data = [];
                if (($handle = fopen($file->getPathname(), 'r')) !== false) {
                    $rowCounter = 0; // Initialize row counter

                    while (($rowData = fgetcsv($handle, 1000, ',')) !== false) {
                        // Skip the first row (header)
                        if ($rowCounter == 0) {
                            $rowCounter++;
                            continue;
                        }

                        // Process data from row 2 onwards
                        $data[] = $rowData;
                        $rowCounter++;
                    }

                    fclose($handle);
                } else {
                    // Handle file opening error
                    return redirect()->route('upload')->with('error', 'Error opening CSV file.');
                }
                try {
                    // dd($data);
                    // Insert data into the database using Eloquent
                    foreach ($data as $row) {
                        // dd($row);
                        Recommendation::create([
                            'report_numbers' => $row[0],
                            'report_title' => $row[1],
                            'audit_type' => $row[2],
                            'publication_date' => $row[3],
                            'page_par_reference' => $row[4],
                            'recommendation' => $row[5],
                            'client' => $row[6],
                            'sector' => $row[7],
                            'key_issues' => $row[8],
                            'acceptance_status' => $row[9],
                            'implementation_status' => $row[10],
                            'recurence' => $row[11],
                            'follow_up_date' => $row[12],
                            'actual_expected_imp_date' => $row[13],
                            'sai_confirmation' => $row[14],
                            'responsible_entity' => $row[15],
                            'summary_of_response' => $row[16],
                        ]);
                    }
                    return redirect()->route('recommendations.index');

                } catch (Exception $e) {
                    $errorMessage = $e->getMessage();

                    // Check for specific error scenarios and flash appropriate error messages
                    if (str_contains($errorMessage, 'Duplicate entry')) {
                        // Handle duplicate key error
                        return redirect()->route('recommendations.create')->with('error', 'Duplicate error: This record already exists.');
                    } elseif (str_contains($errorMessage, 'Invalid datetime format')) {
                        // Handle incorrect date format error
                        return redirect()->route('recommendations.create')->with('error', 'Incorrect date format: Please check the date format to be (yyyy/mm/dd)');
                    } else {
                        // Handle other general errors
                        return redirect()->route('recommendations.create')->with('error', 'An error occurred: ' . $errorMessage);
                    }
                }
            }
        }
    }

    //For final report csv upload
    public function uploadFinalReportExample(Request $request)
    {
        // Check if a file was uploaded
        if ($request->hasFile('excelDoc')) {
            $file = $request->file('excelDoc');

            // Check if the file is a CSV file
            if ($file->getClientOriginalExtension() === 'csv') {

                $data = [];
                if (($handle = fopen($file->getPathname(), 'r')) !== false) {
                    $rowCounter = 0; // Initialize row counter

                    while (($rowData = fgetcsv($handle, 1000, ',')) !== false) {
                        // Skip the first row (header)
                        if ($rowCounter == 0) {
                            $rowCounter++;
                            continue;
                        }

                        // Process data from row 2 onwards
                        $data[] = $rowData;
                        $rowCounter++;
                    }

                    fclose($handle);
                } else {
                    // Handle file opening error
                    return redirect()->route('tracking_page')->with('error', 'Error opening CSV file.');
                }
                try {
                    // Insert data into the database using Eloquent
                    foreach ($data as $row) {

                        FinalReport::create([
                            'country_office' => $row[0],
                            'audit_report_title' => $row[1],
                            'audit_type' => $row[2],
                            'date_of_audit' => $row[3],
                            'publication_date' => $row[4],
                            'page_par_reference' => $row[5],
                            'audit_recommendations' => $row[6],
                            'classfication' => $row[7],
                            'client_id' => $row[8],
                            'client_type' => $row[9],
                            'key_issues' => $row[10],
                            'acceptance_status' => $row[11],
                            'current_implementation_status' => $row[12],
                            'reason_not_implemented' => $row[13],
                            'follow_up_date' => $row[14],
                            'target_completion_date' => $row[15],
                            'recurence' => $row[16],
                            'action_plan' => $row[17],
                            'responsible_person' => $row[18],
                            'sai_confirmation' => $row[19],
                            'responsible_entity' => $row[20],
                            'head_of_audited_entity' => $row[21],
                            'audited_entity_focal_point' => $row[22],
                            'audit_team_lead' => $row[23],
                            'summary_of_response' => $row[24],
                            'responsible_person_email' => $row[25],
                        ]);


                    }
                    return redirect()->route('tracking_page');

                } catch (Exception $e) {
                    $errorMessage = $e->getMessage();

                    // Check for specific error scenarios and flash appropriate error messages
                    if (strpos($errorMessage, 'Duplicate entry') !== false) {
                        // Handle duplicate key error
                        return redirect()->route('tracking_page')->with('error', 'Duplicate key error: This record already exists.');
                    } elseif (strpos($errorMessage, 'Invalid datetime format') !== false) {
                        // Handle incorrect date format error
                        return redirect()->route('tracking_page')->with('error', 'Incorrect date format: Please check the date format to be (yyyy/mm/dd)');
                    } else {
                        // Handle other general errors
                        return redirect()->route('tracking_page')->with('error', 'An error occurred: ' . $errorMessage);
                    }
                }
            }
        }
    }

    public function uploadFinalReport(Request $request)
    {
        // Check if a file was uploaded
        if ($request->hasFile('excelDoc')) {
            $file = $request->file('excelDoc');

            // Check if the file is a CSV file
            if ($file->getClientOriginalExtension() === 'csv') {
                $data = [];
                if (($handle = fopen($file->getPathname(), 'r')) !== false) {
                    $rowCounter = 0;

                    while (($rowData = fgetcsv($handle, 1000, ',')) !== false) {
                        // Skip the first row (header)
                        if ($rowCounter == 0) {
                            $rowCounter++;
                            continue;
                        }

                        // Process data from row 2 onwards
                        $data[] = $rowData;
                        $rowCounter++;
                    }

                    fclose($handle);
                } else {
                    // Handle file opening error
                    return redirect()->route('tracking_page')->with('error', 'Error opening CSV file.');
                }

                // Store the parsed CSV data in the session
                session(['parsedCSVData' => $data]);

                // Retrieve users with their associated roles and lead body
                $users = User::with(['roles', 'leadBody'])->get();

                // Retrieve all LeadBody records where name is not blank
                $leadBodies = LeadBody::whereNotNull('name')
                    ->where('name', '<>', '')
                    ->get(['id', 'name']);
                
                // Retrieve all Category records where name is not blank
                $categories = MainstreamCategory::whereNotNull('name')
                ->where('name', '<>', '')
                ->get(['id', 'name']);
                
                // dd($category);

                // Initialize arrays for each role
                $sai_responsible_person = [];
                $team_lead = [];
                $client_focal_point = [];
                $client_head = [];

                // Filter users based on specified roles
                foreach ($users as $user) {
                    // Filter users for Internal Auditor role
                    if ($user->roles->contains('name', 'Internal Auditor')) {
                        $sai_responsible_person[] = [
                            'id' => $user->id,
                            'name' => $user->name
                        ];
                    }
                    
                    // Filter users for Team Leader role
                    if ($user->roles->contains('name', 'Team Leader')) {
                        $team_lead[] = [
                            'id' => $user->id,
                            'name' => $user->name
                        ];
                    }

                    // Filter users for Audited Entity Focal Point role
                    if ($user->roles->contains('name', 'Audited Entity Focal Point')) {
                        $client_focal_point[] = [
                            'id' => $user->id,
                            'name' => $user->name
                        ];
                    }

                    // Filter users for Head of Audited Entity role
                    if ($user->roles->contains('name', 'Head of Audited Entity')) {
                        $client_head[] = [
                            'id' => $user->id,
                            'name' => $user->name
                        ];
                    }
                }

                // Pass the necessary data to the view
                return view('final_report_preview.index', compact(
                    'users',
                    'sai_responsible_person',
                    'team_lead',
                    'client_focal_point',
                    'client_head',
                    'leadBodies',
                    'categories'
                ));
            }
        }

        // Return an error if the file type is not valid
        return redirect()->route('tracking_page')->with('error', 'Invalid file type. Please upload a CSV file.');
    }


    /**
     * Confirm and save the final report data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    //  public function confirm(Request $request)
    //  {  
    //      // Retrieve the form data
    //      $data = session('parsedCSVData');
    //      $responsiblePersons = $request->input('responsible_person');
    //      $mainstream_categories = $request->input('mainstream_category');
    //      $clients = $request->input('client');
    //      $headOfAuditedEntities = $request->input('head_of_audited_entity');
    //      $auditedEntityFocalPoints = $request->input('audited_entity_focal_point');
    //      $auditTeamLeads = $request->input('audit_team_lead');
        
    //      try {
    //          // Process each entry in the form data
    //          foreach ($data as $index => $row) {
    //              // Retrieve the SAI responsible person ID
    //              $saiResponsiblePersonId = $responsiblePersons[$index];
                 
    //              dd($row);
    //              // Query the users table to retrieve the user record based on the ID
    //              $saiResponsiblePerson = User::find($saiResponsiblePersonId);
                 
    //              // Check if the user record exists and retrieve the email address
    //              $saiResponsiblePersonEmail = $saiResponsiblePerson ? $saiResponsiblePerson->email : null;
     
    //              // Retrieve the client_id from the form data
    //              $client_id = $clients[$index];

    //             // Retrieve the client_id from the form data
    //             $mainstream_categories_id = $mainstream_categories[$index];

    //             // Query the LeadBody table to retrieve the LeadBody record based on the client_id
    //              $leadBody = LeadBody::find($client_id);
                 
    //              // Check if LeadBody record exists and retrieve the client_type_id
    //              $client_type_id = $leadBody ? $leadBody->client_type_id : null;
                 
    //              // Create a new FinalReport record for each entry
    //              FinalReport::create([
    //                  'country_office' => $row[0],
    //                  'audit_report_title' => $row[1],
    //                  'audit_type' => $row[2],
    //                  'date_of_audit' => $row[3],
    //                  'publication_date' => $row[4],
    //                  'page_par_reference' => $row[5],
    //                  'audit_recommendations' => $row[6],
    //                  'classification' => $row[7],
    //                  'key_issues' => $row[10],
    //                  'acceptance_status' => $row[11],
    //                  'current_implementation_status' => $row[12],
    //                  'reason_not_implemented' => $row[13],
    //                  'follow_up_date' => $row[14],
    //                  'target_completion_date' => $row[15],
    //                  'action_plan' => $row[17],
    //                  'summary_of_response' => $row[24],
     
    //                  // Associate fields with the corresponding dropdown selections
    //                  'sai_responsible_person_id' => $saiResponsiblePersonId,
    //                  'mainstream_categories_id' => $mainstream_categories_id,
    //                  'client_id' => $client_id,
    //                  'head_of_audited_entity_id' => $headOfAuditedEntities[$index],
    //                  'audited_entity_focal_point_id' => $auditedEntityFocalPoints[$index],
    //                  'audit_team_lead_id' => $auditTeamLeads[$index],
                     
    //                  // Include the email address of the SAI responsible person
    //                  'responsible_person_email' => $saiResponsiblePersonEmail,
                     
    //                  // Include the client_type_id from the LeadBody table
    //                  'client_type_id' => $client_type_id,
    //              ]);
    //          }
     
    //          // Redirect to a success page or another appropriate route
    //          return redirect()->route('tracking_page')->with('success', 'Final report data saved successfully.');
     
    //      } catch (Exception $e) {
    //          // Handle any exceptions and redirect back with an error message
    //          return redirect()->route('tracking_page')->with('error', 'An error occurred: ' . $e->getMessage());
    //      }
    //  }

    public function confirm(Request $request)
    {
        // Retrieve the form data
        $data = session('parsedCSVData');
        $responsiblePersons = $request->input('responsible_person');
        $mainstream_categories = $request->input('mainstream_category');
        $clients = $request->input('client');
        $headOfAuditedEntities = $request->input('head_of_audited_entity');
        $auditedEntityFocalPoints = $request->input('audited_entity_focal_point');
        $auditTeamLeads = $request->input('audit_team_lead');

        try {
            // Ensure that all necessary fields are provided
            if (!$data || !$responsiblePersons || !$mainstream_categories || !$clients || !$headOfAuditedEntities || !$auditedEntityFocalPoints || !$auditTeamLeads) {
                throw new \Exception('Required data is missing.');
            }

            // Process each unique report title
            $groupedReports = [];
            foreach ($data as $index => $row) {
                if (isset($row[1])) {
                    $reportKey = $row[1];
                    $groupedReports[$reportKey][] = $row;
                }
            }

            foreach ($groupedReports as $reportTitle => $reportRows) {
                // Retrieve the associated data for the current report title
                $saiResponsiblePersonId = $responsiblePersons[md5($reportTitle)];
                $mainstream_category_id = $mainstream_categories[md5($reportTitle)];
                $client_id = $clients[md5($reportTitle)];
                $headOfAuditedEntityId = $headOfAuditedEntities[md5($reportTitle)];
                $auditedEntityFocalPointId = $auditedEntityFocalPoints[md5($reportTitle)];
                $auditTeamLeadId = $auditTeamLeads[md5($reportTitle)];

                // Retrieve the SAI responsible person ID
                $saiResponsiblePerson = User::find($saiResponsiblePersonId);
                $saiResponsiblePersonEmail = $saiResponsiblePerson ? $saiResponsiblePerson->email : null;

                // Retrieve the LeadBody record
                $leadBody = LeadBody::find($client_id);
                $client_type_id = $leadBody ? $leadBody->client_type_id : null;

                // Create FinalReport records for each entry under the same report title
                foreach ($reportRows as $row) {
                    FinalReport::create([
                        'country_office' => $row[0],
                        'audit_report_title' => $row[1],
                        'audit_type' => $row[2],
                        'date_of_audit' => $row[3],
                        'publication_date' => $row[4],
                        'page_par_reference' => $row[5],
                        'audit_recommendations' => $row[6],
                        'classification' => $row[7],
                        'key_issues' => $row[10],
                        'acceptance_status' => $row[11],
                        'current_implementation_status' => $row[12],
                        'reason_not_implemented' => $row[13],
                        'follow_up_date' => $row[14],
                        'target_completion_date' => $row[15],
                        'action_plan' => $row[17],
                        'summary_of_response' => $row[24],

                        // Associate fields with the corresponding dropdown selections
                        'sai_responsible_person_id' => $saiResponsiblePersonId,
                        'mainstream_categories_id' => $mainstream_category_id,
                        'client_id' => $client_id,
                        'head_of_audited_entity_id' => $headOfAuditedEntityId,
                        'audited_entity_focal_point_id' => $auditedEntityFocalPointId,
                        'audit_team_lead_id' => $auditTeamLeadId,

                        // Include the email address of the SAI responsible person
                        'responsible_person_email' => $saiResponsiblePersonEmail,

                        // Include the client_type_id from the LeadBody table
                        'client_type_id' => $client_type_id,
                    ]);
                }
            }

            // Redirect to a success page or another appropriate route
            return redirect()->route('tracking_page')->with('success', 'Final report data saved successfully.');

        } catch (\Exception $e) {
            // Handle any exceptions and redirect back with an error message
            return redirect()->route('tracking_page')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


     private function checkPermission(Recommendation $recommendation): void
    {
        $user = auth()->user();
        if ($user->hasRole('Client') && $user->lead_body_id != $recommendation->client) {
            abort(403, ' You are only allowed to access your own client data.');
        }
    }

    public function getModel()
    {
        return new Recommendation();
    }
     
}
