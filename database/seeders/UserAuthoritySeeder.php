<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\AuthorityInfo;

class UserAuthoritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $authority = AuthorityInfo::getList('user');
        foreach($authority as $name){
            $permission[$name] = 'all';
        }

        \App\Models\UserAuthority::insert([
            'name' => '使用者預設權限',
            'permission' => json_encode($permission),
        ]);
    }
}
