<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\FinalReport;
use App\Models\Recommendation;
use App\Models\ActionPlan;
use App\Models\User;
use App\Notifications\RecommendationNotedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\NoteReply;

class NoteController extends Controller
{   
    // Note replies method
    public function storeReply(Request $request, $noteId)
    {
        $request->validate([
            'reply_message' => 'required|string',
        ]);

        $note = Note::findOrFail($noteId);
        $note->replies()->create([
            'user_id' => auth()->id(),
            'reply_message' => $request->reply_message,
        ]);

        // dd($note);

        return redirect()->back()->with('success', 'Reply added successfully.');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $final_report_id)
    {
        $report = FinalReport::findOrFail($final_report_id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
            'final_report_id' => $final_report_id,
        ]);

        // Notifications for related users
        $this->notifyRelatedUsers($report);

        return redirect()->back()->with('success', 'Note added successfully');
    }

    /**
     * Notify related users about the note.
     */
    private function notifyRelatedUsers($report)
    {
        $relatedUsers = [
            'responsible_person' => User::find($report->sai_responsible_person_id),
            'head_of_audited_entity' => User::find($report->head_of_audited_entity_id),
            'audited_entity_focal_point' => User::find($report->audited_entity_focal_point_id),
            'audit_team_lead' => User::find($report->audit_team_lead_id)
        ];

        foreach ($relatedUsers as $user) {
            if ($user) {
                $user->notify(new RecommendationNotedNotification($report));
            }
        }
    }


    /**
     * Display a listing of the notes.
     */
    public function index()
    {
        $notes = Note::all();
        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new note.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Display the specified note.
     */
    public function show($final_report_id)
    {
        $finalReport = FinalReport::with('notes.user')->findOrFail($final_report_id);
        return view('notes.show', compact('finalReport'));
    }

    /**
     * Show the form for editing the specified note.
     */
    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified note in storage.
     */
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
    
        $note->update($request->only(['title', 'content']));
    
        return redirect()->route('notes.show', $note->final_report_id)->with('success', 'Note updated successfully');
    }
    /**
     * Remove the specified note from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->back()->with('success', 'Note deleted successfully');
    }


    //For showing reports required making notes
    public function reportsshow()
    {
        // Retrieve distinct report titles
        $uniqueReportTitles2 = FinalReport::distinct('audit_report_title')
            ->when(Auth::user()->hasRole('Client'), function ($query) {
                $query->where('client_id', auth()->user()->lead_body_id);
            })
            ->whereDate('target_completion_date', '>=', now())
            ->where('current_implementation_status', '!=', 'Fully Implemented')
            ->pluck('audit_report_title');

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

        return view('notes.index', compact('uniqueReportDetails2'));
    }

    public function showNotesReportDetails($id)
    {
        // Retrieve the final report by ID
        $actionPlan = FinalReport::findOrFail($id);
    
        // Retrieve all reports that share the same audit report title and join with ClientType
        $reportTitle = $actionPlan->audit_report_title;
        $reportDetails = FinalReport::where('audit_report_title', $reportTitle)
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
                'notescount' // Include notes relationship
            ])
            ->get();
    
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
    
            // Count the notes for each recommendation
            $reportDetail->notes_count = $reportDetail->notescount->count();
        }
    
        // Return the view with the report details
        return view('notes.report_details', compact('reportDetails'));
    }

    public function showNotesDetailsView(int $id)
    {
        $finalReport = FinalReport::findOrFail($id);
    
        // Load notes with the user and their replies along with the user who replied
        $finalReport->load('notes.user', 'notes.replies.user');
        return view('notes.show', compact('finalReport'));
    } 

    public function getModel()
    {
        return new Note();
    }
    

}

