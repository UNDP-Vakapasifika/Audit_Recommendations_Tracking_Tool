<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadBodiesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'list lead bodies',
            'view lead bodies',
            'create lead bodies',
            'edit lead bodies',
            'delete lead bodies',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        $admin = User::role('admin')->first();

        if ($admin) {
            $admin->givePermissionTo($permissions);
        }
    }
}
