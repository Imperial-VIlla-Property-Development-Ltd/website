<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultUsersSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'imperialvillapropertyltd@gmail.com'],
            [
                'name' => 'Portal Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Super Admin
        User::updateOrCreate(
            ['email' => 'silasjonathan106@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Silas@1234'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );
    
    
        User::updateOrCreate(
            ['email' => 'silasjonathan2023@gmail.com'],
            [
                'name' => 'Second Admin',
                'password' => Hash::make('Silas@1234'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}
