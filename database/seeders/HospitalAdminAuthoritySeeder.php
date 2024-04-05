<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\AuthorityInfo;

class HospitalAdminAuthoritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authority = AuthorityInfo::getList('hospital');
        foreach($authority as $name){
            $permission[$name] = 'all';
        }

        \App\Models\HospitalAdminAuthority::insert([
            'hospital_id' => 1,
            'name' => '醫院預設權限',
            'permission' => json_encode($permission),
        ]);
    }
}
