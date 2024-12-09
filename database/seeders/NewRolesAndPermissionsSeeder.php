<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class NewRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'upload recommendations',
            'view recommendations',
            'edit recommendations',
            'delete recommendations',
            'view all report tables',
            'view final report',
            'change final report status',
            'create action plan',
            'edit action plan',
            'view action plan',
            'supervise action plan',
            'view tracking tables',
            'create stakeholders',
            'edit stakeholders',
            'view stakeholders',
            'delete stakeholders',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create or find the Admin role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Assign all permissions to the Admin role
        $adminRole->syncPermissions(Permission::all());

        // Assign the Admin role to any users who have it
        $users = User::role('Admin')->get();

        foreach ($users as $user) {
            $user->syncPermissions(Permission::all());
        }
    }
}
