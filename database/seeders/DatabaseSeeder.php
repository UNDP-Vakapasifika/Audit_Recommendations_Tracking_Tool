<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\FinalReportFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // $this->call(UserSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(NewRolesAndPermissionsSeeder::class);
        $this->call(CautionPermissionsSeeder::class);
        $this->call(LeadBodiesPermissionsSeeder::class);
        $this->call(MainStreamCategories::class);
        // $this->call(SAI_Details::class);
    }

    // private function createDefaultUser(): void
    // {
    //     $defaultUser = [
    //         'name' => 'UNDP-Admin',
    //         'email' => 'admin@gmail.com',
    //         'password' => Hash::make('UNDP$$1208'),
    //     ];
    //     User::create($defaultUser);
    // }
}
