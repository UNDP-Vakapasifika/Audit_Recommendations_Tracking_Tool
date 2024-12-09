<?php

namespace App\Http\Controllers;

use App\Models\Stakeholder;
use App\Models\User;
use Illuminate\Http\Request;

class StakeholderController extends Controller
{
    // Display a listing of the stakeholders.
    public function index()
    {
        $stakeholders = Stakeholder::all();
        return view('stakeholder.index', compact('stakeholders'));
    }

    // Show the form for creating a new stakeholder.
    public function create()
    {
        return view('stakeholder.create');
    }

    // Store a newly created stakeholder in the database.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'postal_address' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        $stakeholder = new Stakeholder;
        $stakeholder->name = $request->name;
        $stakeholder->location = $request->location;
        $stakeholder->postal_address = $request->postal_address;
        $stakeholder->telephone = $request->telephone;
        $stakeholder->email = $request->email;
        $stakeholder->website = $request->website;
        $stakeholder->save();

        return redirect()->route('stakeholder.index')->with('success', 'Stakeholder created successfully.');
    }

    // Show the form for editing the specified stakeholder.
    public function edit($id)
    {
        $stakeholder = Stakeholder::findOrFail($id);

        return view('stakeholder.edit', [
            'stakeholder' => $stakeholder,
        ]);
    }

    // Update the specified stakeholder in the database.
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'postal_address' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        $stakeholder = Stakeholder::findOrFail($id);
        $stakeholder->update([
            'name' => $request->name,
            'location' => $request->location,
            'postal_address' => $request->postal_address,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'website' => $request->website,
        ]);

        return redirect()->route('stakeholder.index')->with('success', 'Stakeholder updated successfully.');
    }

    public function show($id)
    {
        $stakeholder = Stakeholder::findOrFail($id);
        $users = User::where('stakeholder_id', $stakeholder->id)->get();

        return view('stakeholder.show', compact('stakeholder', 'users'));
    }

    // Remove the specified stakeholder from the database.
    public function destroy($id)
    {
        $stakeholder = Stakeholder::findOrFail($id);

        // Check if there are associated users
        $userCount = User::where('stakeholder_id', $stakeholder->id)->count();

        if ($userCount > 0) {
            return redirect()->route('stakeholder.index')->with('error', 'Cannot delete stakeholder with associated users.');
        }

        // If no associated users, proceed with deletion
        $stakeholder->delete();
        return redirect()->route('stakeholder.index')->with('success', 'Stakeholder deleted successfully.');
    }
}
