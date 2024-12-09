<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CautionPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'see final report cautions',
            'create final report cautions',
            'add final report cautions',
            'delete final report cautions',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        $role = \Spatie\Permission\Models\Role::findByName('Admin');

        $role->givePermissionTo($permissions);
    }
}
