<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SAI_Details extends Seeder
{
    public function run(): void
    {
        DB::table('stakeholders')->insert([
            'name' => 'SAI Name ',
            'location' => 'Government Buildings',
            'postal_address' => 'PO Box 2214',
            'telephone' => '+679 111 111 111',
            'email' => 'info@auditorgeneral.gov.fsm ',
            'website' => 'www.oag.gov.fsm',
        ]);
    }
}
