<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view role')->only('index', 'show');
        $this->middleware('permission:create role')->only('create', 'store');
        $this->middleware('permission:edit role')->only('edit', 'update');
        $this->middleware('permission:delete role')->only('destroy');
    }

    public function index(): View
    {
        $roles = Role::all();

        $roles->map(function($role){
            $role->users_count = $role->users()->count();
            $role->permissions_count = $role->permissions()->count();
        });
        return view('roles.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permission::all()->pluck('name');

        return view('roles.create', compact('permissions'));
    }

    public function show(Role $role): View
    {
        $role->load('permissions', 'users');

        return view('roles.show', compact('role'));
    }

    public function store(Request $request): RedirectResponse
    {
        $roleAlreadyExists = Role::where('name', $request->{'name'})->first();

        if ($roleAlreadyExists) {
            Log::info('Role already exists');
            return redirect()->route('roles.index')->with('error', 'Role created');
        }

        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array|min:1'
        ]);

        $role = Role::create(['name' => $request->{'name'}]);

        $role->syncPermissions($request->{'permissions'});

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    public function edit(Role $role): View
    {
        $permissions = Permission::all()->pluck('name');
        $role_permissions = $role->permissions()->pluck('name');

        return view('roles.create', compact('role', 'permissions', 'role_permissions'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required|array|min:1'
        ]);

        $role->update(['name' => $request->{'name'}]);

        $role->syncPermissions($request->{'permissions'});

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->name === 'Admin') {
            return redirect()->route('roles.index')->with('error', 'You cannot delete the Admin role');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'You cannot delete a role with users');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}
