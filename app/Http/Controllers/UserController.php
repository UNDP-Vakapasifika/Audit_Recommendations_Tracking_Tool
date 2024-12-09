<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\LeadBody;
use App\Models\Stakeholder;
use App\Models\User;
use App\Models\ImplementationStatusChange;
use App\Notifications\UserCreatedNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    public function index(): View
    {
        $admins = User::whereNull('lead_body_id')->whereNull('stakeholder_id')->get();
        $stakeholders = User::whereNotNull('stakeholder_id')->distinct('stakeholder_id')->with('stakeholder')->get();
        $clients = User::whereNotNull('lead_body_id')->distinct('lead_body_id')->with('leadBody')->get();
    
        // Calculate ratings for admins
        foreach ($admins as $admin) {
            $ratingCount = ImplementationStatusChange::where('changed_by', $admin->id)
                ->whereIn('to_status', ['Fully Implemented', 'Partially Implemented'])
                ->count();
    
            // Assume a rating scale of 0 to 5 based on the count
            $admin->rating = $this->calculateRating($ratingCount);
        }
    
        // Calculate ratings for clients
        foreach ($clients as $client) {
            $clientUsers = User::where('lead_body_id', $client->lead_body_id)->get();
            $totalActivities = 0;
    
            foreach ($clientUsers as $user) {
                $totalActivities += ImplementationStatusChange::where('changed_by', $user->id)
                    ->whereIn('to_status', ['Fully Implemented', 'Partially Implemented'])
                    ->count();
            }
    
            // Assume a larger rating scale for clients
            $client->rating = $this->calculateClientRating($totalActivities);
        }
    
        return view('users.index', [
            'admins' => $admins,
            'stakeholders' => $stakeholders,
            'clients' => $clients,
        ]);
    }
    
    
    public function showByStakeholder($id)
    {
        $users = User::where('stakeholder_id', $id)->with('stakeholder')->get();
    
        // Calculate ratings for users
        foreach ($users as $user) {
            $ratingCount = ImplementationStatusChange::where('changed_by', $user->id)
                ->whereIn('to_status', ['Fully Implemented', 'Partially Implemented'])
                ->count();
    
            $user->rating = $this->calculateRating($ratingCount);
        }
    
        return view('users.user_details', [
            'users' => $users,
            'category' => 'Stakeholder',
            'categoryName' => $users->first()->stakeholder->name ?? 'N/A',
        ]);
    }
    

    public function showByClient($id)
    {
        $users = User::where('lead_body_id', $id)->with('leadBody')->get();
    
        // Calculate ratings for users
        foreach ($users as $user) {
            $ratingCount = ImplementationStatusChange::where('changed_by', $user->id)
                ->whereIn('to_status', ['Fully Implemented', 'Partially Implemented'])
                ->count();
    
            $user->rating = $this->calculateRating($ratingCount);
        }
    
        return view('users.user_details', [
            'users' => $users,
            'category' => 'Client',
            'categoryName' => $users->first()->leadBody->name ?? 'N/A',
        ]);
    }

    private function calculateRating(int $count): int
    {
        if ($count > 20) {
            return 5;
        } elseif ($count > 15) {
            return 4;
        } elseif ($count > 10) {
            return 3;
        } elseif ($count > 5) {
            return 2;
        } elseif ($count > 0) {
            return 1;
        } else {
            return 0; // No activity
        }
    }

    private function calculateClientRating(int $count): int
    {
        // Assume a rating scale of 0 to 5 based on a larger count range for clients
        if ($count > 100) {
            return 5;
        } elseif ($count > 75) {
            return 4;
        } elseif ($count > 50) {
            return 3;
        } elseif ($count > 25) {
            return 2;
        } elseif ($count > 0) {
            return 1;
        } else {
            return 0; // No activity
        }
    }

    public function makeAdmin(User $user)
    {
        // Add your logic to make the user an admin
        $adminRole = Role::where('name', 'admin')->first();
        $user->roles()->sync([$adminRole->id]);
    
        // Set lead_body_id and stakeholder_id to null
        $user->lead_body_id = null;
        $user->stakeholder_id = null;
        $user->save();
    
        return redirect()->route('users.index')->with('success', 'User has been made an admin.');
    }
    


    
    public function show(User $user): View
    {
        $permissions = $user->getAllPermissions();

        $user->load('activityLogs');

        return view('users.show', ['user' => $user, 'permissions' => $permissions]);
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        $leadBodies = LeadBody::all();
        $stakeholders = Stakeholder::all();
        return view('users.create', ['user' => $user, 'roles' => $roles, 'leadBodies' => $leadBodies, 'stakeholders' => $stakeholders]);
    }

    public function create(): View
    {
        $roles = Role::all();
        $leadBodies = LeadBody::all();
        $stakeholders = Stakeholder::all();

        return view('users.create', ['roles' => $roles, 'leadBodies' => $leadBodies, 'stakeholders' => $stakeholders]);
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        // Validate request
        if(isset($request->{'lead_body_id'}) && isset($request->{'stakeholder_id'})) {
            return back()->withError('You cannot assign a user as both client and stakeholder at the same time. Choose one!');
        }
        // $password = Str::random(8);
        $password = 'Password@12';


        $user = User::create([
            'name' => $request->{'name'},
            'email' => $request->{'email'},
            'password' => bcrypt($password),
            'lead_body_id' => $request->{'lead_body_id'},
            'stakeholder_id' => $request->{'stakeholder_id'}
        ]);

        $user->assignRole($request->{'role'});

        // $user->notify(new UserCreatedNotification($password));

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function update(CreateUserRequest $request, User $user): RedirectResponse
    {
        // Validate request
        if(isset($request->{'lead_body_id'}) && isset($request->{'stakeholder_id'})) {
            return back()->withError('You cannot assign a user as both client and stakeholder at the same time. Choose one!');
        }
        $user->update($request->safe()->except('role'));

        $user->syncRoles($request->{'role'});

        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function getModel()
    {
        return new User();
    }
}
