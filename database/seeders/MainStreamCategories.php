<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MainStreamCategories extends Seeder
{
    public function run(): void
    {
        DB::table('mainstream_categories')->insert([
            'name' => 'Economic Autonomy',
        ]);

        DB::table('mainstream_categories')->insert([
            'name' => 'Physical Autonomy',
        ]);

        DB::table('mainstream_categories')->insert([
            'name' => 'Decision-making Autonomy',
        ]);

        DB::table('mainstream_categories')->insert([
            'name' => 'Not Applicable',
        ]);
    }
}
