<?php

namespace App\Http\Controllers;

use App\Models\FinalReport;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use PDF;


class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view all report tables')->only('index');
    }

    public function index()
    {
        // Query to get recommendations by status with eager loading for LeadBody and User relationships
        $acceptedRecommendations = FinalReport::where('acceptance_status', 'Accepted')
            ->when(Auth::user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })
            ->with(['leadBody' => function ($query) {
                $query->select('id', 'name');
            }, 'saiResponsiblePerson' => function ($query) {
                $query->select('id', 'name');
            }])
            ->get();

        $implementedRecommendations = FinalReport::where('current_implementation_status', 'Fully Implemented')
        ->when(Auth::user()->hasRole('Client'), function ($query) {
            $query->where('client_id', auth()->user()->lead_body_id);
        })
        ->with(['countryOffice', 'client', 'saiResponsiblePerson'])
        ->get();
        
        $partiallyImplementedRecommendations = FinalReport::where('current_implementation_status', 'Partially Implemented')
        ->when(Auth::user()->hasRole('Client'), function ($query) {
            $query->where('client_id', auth()->user()->lead_body_id);
        })
        ->with(['countryOffice', 'client'])
        ->get();

        // dd($partiallyImplementedRecommendations);
        
        $notImplementedRecommendations = FinalReport::where('current_implementation_status', 'Not Implemented')
            ->when(Auth::user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })
            ->with(['countryOffice', 'client'])
            ->get();
    
        $noupdateImplementedRecommendations = FinalReport::where('current_implementation_status', 'No Update')
            ->when(Auth::user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })
            ->with(['countryOffice', 'client'])
            ->get();
        
        $noLongerApplicableRecommendations = FinalReport::where('current_implementation_status', 'No Longer Applicable')
        ->when(Auth::user()->hasRole('Client'), function ($query) {
            $query->where('client_id', auth()->user()->lead_body_id);
        })
        ->with(['countryOffice', 'client'])
        ->get();
        
        // Query to get recommendations with recurrence "Yes"
        $recurrenceYesRecommendations = Recommendation::where('recurence', 'Yes')
            ->when(Auth::user()->hasRole('Client'), function ($query) {
                $query->where('client', auth()->user()->lead_body_id);
            })
            ->get();    

        return view('reports', compact(
            'acceptedRecommendations',
            'implementedRecommendations',
            'partiallyImplementedRecommendations',
            'notImplementedRecommendations',
            'recurrenceYesRecommendations',
            'noupdateImplementedRecommendations',
            'noLongerApplicableRecommendations'
        ));
    }


    public function reportDueOnTheDate(Request $request)
    {
        $date = $request->query('date');

        $reportsDueOnTheDate = FinalReport::where('target_completion_date', $date)
            ->when(Auth::user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })->get();

        return view('reports_due', compact('reportsDueOnTheDate'));
    }

    // public function printUnimplementedReports()
    // {
    //     $finalReports = FinalReport::with([
    //         'leadBody',
    //         'clientType',
    //         'mainstreamCategory',
    //         'saiResponsiblePerson',
    //         'headOfAuditedEntity',
    //         'auditedEntityFocalPoint',
    //         'auditTeamLead'
    //     ])->where('current_implementation_status', '!=', 'Fully Implemented')
    //       ->when(Auth::user()->hasRole('Client'), function ($query) {
    //           $query->where('client_id', auth()->user()->lead_body_id);
    //       })->get();

    //     $pdf = PDF::loadView('reports.unimplemented_report_pdf', compact('finalReports'))
    //                ->setPaper('a4', 'landscape');

    //     return $pdf->download('unimplemented_reports.pdf');
    // }

        // Method to fetch unimplemented reports
        private function getUnimplementedReports()
        {
            return FinalReport::with([
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
        }
    
        // Method to generate the PDF for preview
        public function preview(Request $request)
        {
            $unimplementedReports = $this->getUnimplementedReports();
            return view('reports.unimplemented_report', compact('unimplementedReports'));
        }
    
        public function download(Request $request)
        {
            try {
                // Fetch the unimplemented reports
                $unimplementedReports = $this->getUnimplementedReports();
                
                // Prepare the data to be passed to the view
                $data = ['unimplementedReports' => $unimplementedReports];
                
                // Generate PDF from the view
                $pdf = PDF::loadView('reports.unimplemented_preview', $data)->setPaper('a3', 'landscape');
                
                // Return the PDF content as a response for preview
                return $pdf->stream('audit_report.pdf'); // Use stream() for preview
                
            } catch (\Exception $e) {
                Log::error('PDF Generation Error: '.$e->getMessage());
                return response()->json(['error' => 'There was an error generating the PDF. Please try again.'], 500);
            }
        }
        
}
