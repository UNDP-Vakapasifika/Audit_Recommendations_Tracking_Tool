<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Stakeholder;
use App\Models\Tool;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SetupController extends Controller
{
    // public function index()
    // {
    //     $stakeholders = DB::table('stakeholders')->count();
    //     $tools = DB::table('tools')->count();
    //     $users = DB::table('users')->count();

    //     if ($stakeholders == 0) {
    //         return view('setup.sai');  // Show SAI setup form
    //     } elseif ($tools == 0) {
    //         return view('setup.tool');  // Show Tool setup form
    //     } elseif ($users == 0) {
    //         return view('setup.admin');  // Show Admin setup form
    //     } else {
    //         return redirect()->route('login');  // Redirect to login if setup is done
    //     }
    // }

    public function index()
    {
        $stakeholders = DB::table('stakeholders')->count();
        $tools = DB::table('tools')->count();
        $users = DB::table('users')->count();

        if ($tools == 0) {
            return view('setup.tool');  // Show SAI setup form
        } elseif ($stakeholders == 0) {
            return view('setup.sai');  // Show Tool setup form
        } elseif ($users == 0) {
            return view('setup.admin');  // Show Admin setup form
        } else {
            return redirect()->route('login');  // Redirect to login if setup is done
        }
    }

    public function setupSAI(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'postal_address' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'required|url|max:255',
        ]);

        Stakeholder::create($request->all());

        return redirect()->route('setup.index');
    }

    public function setupTool(Request $request)
    {
        // Validate the request
        $request->validate([
            'tool_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Initialize logo path
        $logoPath = 'default_logo.png'; // Default logo if no file is uploaded

        // Check if a file was uploaded
        if ($request->hasFile('logo')) {
            // Store the file in the public/img/logo directory
            $file = $request->file('logo');
            $logoPath = 'img/logo/' . $file->getClientOriginalName(); // Create a path for the file

            // Move the file to the public/img/logo directory
            $file->move(public_path('img/logo'), $file->getClientOriginalName());
        }

        // Create a new Tool instance and save it to the database
        Tool::create([
            'tool_name' => $request->tool_name,
            'logo_path' => $logoPath, // Store the path relative to the public folder
        ]);

        // Redirect back or to another route
        return redirect()->route('setup.index');
    }

    // Display the settings form
    public function settings()
    {
        $tool = Tool::first(); // Get the first tool record
        return view('setup.tool_settings', compact('tool'));
    }

    // Update the tool settings
    public function updateToolSettings(Request $request)
    {
        // Validate the request
        $request->validate([
            'tool_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Retrieve the existing tool instance
        $tool = Tool::first();

        if ($tool) {
            // Check if a new logo was uploaded
            if ($request->hasFile('logo')) {
                // Delete the old logo file if it exists
                if ($tool->logo_path && Storage::exists('public/' . $tool->logo_path)) {
                    Storage::delete('public/' . $tool->logo_path);
                }

                // Store the new logo file in the public/img/logo directory
                $file = $request->file('logo');
                $logoPath = 'img/logo/' . $file->getClientOriginalName();

                // Move the file to the public/img/logo directory
                $file->move(public_path('img/logo'), $file->getClientOriginalName());

                // Update the tool logo path
                $tool->logo_path = $logoPath;
            }

            // Update the tool name
            $tool->tool_name = $request->tool_name;
            $tool->save(); // Save changes
        }

        return redirect()->route('settings.index')->with('status', 'Tool settings updated successfully.');
    }


    public function setupAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the first user (Admin)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Check if the Admin role exists, otherwise create it
        $adminRole = Role::firstOrCreate(['name' => 'Admin'], [
            'guard_name' => 'web',
        ]);

        // Assign all permissions to the Admin role
        $adminRole->givePermissionTo(Permission::all());

        // Assign the Admin role to the first user
        $user->assignRole($adminRole);

        return redirect()->route('login');
    }
}


