<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'first_name' => 'Duc',
            'last_name' => 'Dang Hoang',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('meiizyyyy'), 
            'role' => 'admin',
        ]);
    }
}
