<?php

namespace App\Http\Controllers;

use App\Models\AuditPractitioner;
use Illuminate\Http\Request;

class AuditPractitionerController extends Controller
{
    public function index()
    {
        return view('audit_practitioners');
    }
    public function create()
    {
        return view('audit_practitioners.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:audit_practitioners,email',
            'role' => 'required',
            'audit_department' => 'required',
            'employment_number' => 'nullable',
        ]);

        AuditPractitioner::create($validatedData);

        return redirect()->route('audit-practitioners.show')->with('success', 'Audit Practitioner created successfully.');
    }

    public function show()
    {
    $practitioners = AuditPractitioner::all();

    return view('audit_practitioner_show', compact('practitioners'));
    }

    // public function edit($id)
    // {
    //     $practitioner = AuditPractitioner::findOrFail($id);
    //     return view('audit_practitioners_edit', compact('practitioner'));
    // }

    public function edit(AuditPractitioner $audit_practitioner)
    {
        // dd($audit_practitioner);
        return view('audit_practitioners_edit', compact('audit_practitioner'));
    }


    public function update(Request $request, $id)
    {
        $practitioner = AuditPractitioner::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'audit_department' => 'required',
            'role' => 'required',
            'employment_number' => 'required',
        ]);

        $practitioner->update($validatedData);
        return redirect()->route('audit-practitioners.show', ['audit_practitioner' => $practitioner->id]);
        // return redirect()->route('audit-practitioners.show')->with('success', 'Practitioner updated successfully.');
    }

    public function destroy($id)
    {
        $practitioner = AuditPractitioner::findOrFail($id);
        
        $practitioner->delete();

        return redirect()->route('audit-practitioners.show');
    }

}
