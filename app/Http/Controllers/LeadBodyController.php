<?php

namespace App\Http\Controllers;

use App\Models\LeadBody;
use App\Models\ClientType;
use App\Models\User;
use Illuminate\Http\Request;

class LeadBodyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list lead bodies')->only('index');
        $this->middleware('permission:view lead bodies')->only('show');
        $this->middleware('permission:create lead bodies')->only(['create', 'store']);
        $this->middleware('permission:edit lead bodies')->only(['edit', 'update']);
        $this->middleware('permission:delete lead bodies')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Retrieve client types with their related lead bodies
        $clientTypes = ClientType::with(['leadBodies'])->get();

        // Retrieve lead bodies with the count of associated users
        $leadBodies = LeadBody::withCount('users')->get();

        // Create a data structure to hold client types and lead bodies information
        $data = [];

        foreach ($clientTypes as $clientType) {
            // Initialize an array to hold lead bodies information
            foreach ($clientType->leadBodies as $leadBody) {
                // Find the matching lead body in the leadBodies collection to get the user count
                $matchingLeadBody = $leadBodies->firstWhere('id', $leadBody->id);

                // Add lead body data and user count
                $data[] = [
                    'lead_body_name' => $leadBody->name,
                    'client_type_name' => $clientType->name,
                    'users_count' => $matchingLeadBody ? $matchingLeadBody->users_count : 0,
                    'lead_body_id' => $leadBody->id,
                ];
            }
        }

        // Return the view with the structured data
        return view('lead_bodies.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('lead_bodies.create');

        $clientTypes = ClientType::all();
        return view('lead_bodies.create', ['clientTypes' => $clientTypes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        LeadBody::create($request->all());

        return redirect()->route('lead-bodies.index')->with('success', 'Lead body created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadBody $leadBody)
    {
        $leadBody->load('users');
        return view('lead_bodies.show', [
            'leadBody' => $leadBody,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadBody $leadBody)
    {
        $clientTypes = ClientType::all();
        
        return view('lead_bodies.edit', [
            'leadBody' => $leadBody,
            'clientTypes' => $clientTypes,
        ]);
    }
 
    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, LeadBody $leadBody)
    // {
    //     $leadBody->update($request->all());

    //     return redirect()->route('lead-bodies.index')->with('success', 'Lead body updated successfully');
    // }

    public function update(Request $request, $lead_body_id)
    {
        $leadBody = LeadBody::findOrFail($lead_body_id);
        $leadBody->update($request->all());

        return redirect()->route('lead-bodies.index')->with('success', 'Lead body updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(LeadBody $leadBody)
    // {
    //     $leadBody->delete();

    //     return redirect()->route('lead-bodies.index')->with('success', 'Lead body deleted successfully');
    // }

    // public function destroy($lead_body_id)
    // {
    //     $leadBody = LeadBody::findOrFail($lead_body_id);
    //     $leadBody->delete();
    //     return redirect()->route('lead-bodies.index')->with('success', 'Lead body deleted successfully');
    // }

    public function destroy($lead_body_id)
{
    // Find the lead body by ID
    $leadBody = LeadBody::findOrFail($lead_body_id);

    // Check if there are any users associated with the lead body
    if ($leadBody->users()->count() > 0) {
        // If there are users associated, redirect with an error message
        return redirect()->route('lead-bodies.index')->with('error', 'Cannot delete lead body because it has associated users.');
    }

    // If there are no associated users, delete the lead body
    $leadBody->delete();

    // Redirect with a success message
    return redirect()->route('lead-bodies.index')->with('success', 'Lead body deleted successfully');
}
    

}
