<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\AuthorityInfo;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authority = AuthorityInfo::getList('admin');
        foreach($authority as $name){
            $permission[$name] = 'all';
        }

        \App\Models\Admin::insert([
            'account' => 'admin',
            'password' => '$2a$10$SAbX5mRZuqtv4X0xdwb3Q.7aZIvN3bRFxoIrj1a6ltBL3JqLuYoRm', //admin
            'name' => 'Admin',
            'email' => 'admin@admin.com.tw',
            'permission' => json_encode($permission),
        ]);
    }
}
