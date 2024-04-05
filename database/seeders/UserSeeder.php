<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::insert([
            'account' => 'user',
            'password' => '$2a$10$qDnQirmbBHJVA8un0FP3RuN8Nk3xiejpdCPtVUyjJCSGFaVwmT1F6', //user
            'name' => 'User',
            'email' => 'user@user.com.tw',
            'user_authority_id' => 1,    
        ]);
    }
}
