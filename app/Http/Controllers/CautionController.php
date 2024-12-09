<?php

namespace App\Http\Controllers;

use App\Models\Caution;
use App\Models\FinalReport;
use App\Models\User;
use App\Notifications\ReportCautionedNotification;
use Illuminate\Http\Request;

class CautionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $report = FinalReport::findOrFail($id);

        $request->validate([
            'message' => 'required',
        ]);

        Caution::create([
            'message' => $request->message,
            'user_id' => auth()->id(),
            'final_report_id' => $id,
        ]);

        $responsible_persons = User::where('name', $report->responsible_person)->first();

        if ($responsible_persons) {
            $responsible_persons->notify(new ReportCautionedNotification($report));
        }

        $head_of_audited_entity = User::where('name', $report->head_of_audited_entity)->first();

        if ($head_of_audited_entity) {
            $head_of_audited_entity->notify(new ReportCautionedNotification($report));
        }

        $audited_entity_focal_point = User::where('name', $report->audited_entity_focal_point)->first();

        if ($audited_entity_focal_point) {
            $audited_entity_focal_point->notify(new ReportCautionedNotification($report));
        }

        $audit_team_lead = User::where('name', $report->audit_team_lead)->first();

        if ($audit_team_lead) {
            $audit_team_lead->notify(new ReportCautionedNotification($report));
        }


        return redirect()->back()->with('success', 'Caution added successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Caution $caution)
    {
        $caution->delete();

        return redirect()->back()->with('success', 'Caution deleted successfully');
    }

    public function getModel()
    {
        return new Caution();
    }
}
