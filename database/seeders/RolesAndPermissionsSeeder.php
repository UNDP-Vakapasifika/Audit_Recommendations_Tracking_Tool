<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'list users']);

        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'edit role']);
        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'view role']);
        Permission::create(['name' => 'assign role']);
        Permission::create(['name' => 'revoke role']);

        Permission::create(['name' => 'view user permissions']);
        Permission::create(['name' => 'assign permissions']);

        Permission::create(['name' => 'view user logs']);

        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Head of SAI']);
        Role::create(['name' => 'Financial Auditor']);
        Role::create(['name' => 'Perfomance Auditor']);
        Role::create(['name' => 'Compliance Auditor']);

        Role::create(['name' => 'Head of Audited Entity']);
        Role::create(['name' => 'Audited Entity Focal Point']);
        Role::create(['name' => 'Team Leader']);
        Role::create(['name' => 'PTeam Leader']);
        Role::create(['name' => 'Internal Auditor']);

        Role::create(['name' => 'Client']);

        // $admin->givePermissionTo(Permission::all());

        // $user = User::where('email', 'admin@gmail.com')->first();
        // $user->assignRole($admin);
    }
}
