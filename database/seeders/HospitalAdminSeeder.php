<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\HospitalAdmin::insert([
            'hospital_id' => 1,
            'account' => 'hospital',
            'password' => '$2a$10$5ZWOjguXs.xEGGX81lBPCOuVE4gQprCJ0ZIBsSievXPgeGXlPhWgG', //hospital
            'name' => 'Hospital User',
            'email' => 'hospital_user@hospital.com.tw',
            'hospital_admin_authority_id' => 1,
        ]);
    }
}
