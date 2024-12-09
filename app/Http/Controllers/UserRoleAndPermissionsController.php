<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UserRoleAndPermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:assign permissions']);
    }

    public function changePermissionView(User $user): View
    {
        $user_permissions = $user->getAllPermissions()->pluck('name');
        $all_permissions = Permission::all()->pluck('name');

        return view('users.change_permissions',
            ['user' => $user, 'user_permissions' => $user_permissions, 'all_permissions' => $all_permissions]);
    }
    public function changePermissions(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'permissions' => 'required|array|min:1'
        ]);

        $user->syncPermissions($request->{'permissions'});

        return redirect()->route('users.show', $user->{'id'})->with('success', 'Permissions changed successfully');
    }

    public function getModel()
    {
        return new Permission();
    }
}
