<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\AuthorityInfo;

class HospitalSeeder extends Seeder
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

        \App\Models\Hospital::insert([
            'name' => '測試醫院',
            'address' => '104我是地址我是地址我是地址',
            'email' => 'hospital_user@hospital.com.tw',
            'tel' => '02-2999-9999',
            'fax' => '02-2888-8888',
            'permission' => json_encode($permission),
        ]);
    }
}
