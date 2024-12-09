<?php

namespace App\Http\Controllers;

use App\Models\ClientType;
use Illuminate\Http\Request;


class ClientTypeController extends Controller
{
    //
    public function index(){
        $clientTypes = ClientType::all();
        return view('client_type.index', compact('clientTypes'));
    }

    public function create(){
        return view('client_type.create');
    }

    // Store a newly created client type
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $clientType = new ClientType;
        $clientType->name = $request->name;
        $clientType->save();

        return redirect()->route('client-types.index')->with('success', 'Client type created successfully.');
    }

    public function edit($id)
    {
        $clientType = ClientType::findOrFail($id);

        return view('client_type.edit', [
            'clientType' => $clientType,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $clientType = ClientType::findOrFail($id);
        $clientType->update([
            'name' => $request->name,
        ]);

        return redirect()->route('client-types.index')->with('success', 'Client type updated successfully.');
    }

    public function destroy($id)
    {
        $clientType = ClientType::findOrFail($id);

        // Check if the client type has associated records
        if ($clientType->leadBodies()->count() > 0) {
            return redirect()->route('client-types.index')->with('error', 'Client type cannot be deleted because it has associated records.');
        }

        // If no associated records, delete the client type
        $clientType->delete();

        return redirect()->route('client-types.index')->with('success', 'Client type deleted successfully.');
    }

}
