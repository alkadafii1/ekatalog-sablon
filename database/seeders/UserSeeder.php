<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin123'),
            'role' => 'admin',
        ]);

        // User biasa
        User::create([
            'name' => 'User1',
            'email' => 'user@gmail.com',
            'password' => Hash::make('User12345'),
            'role' => 'user',
        ]);
    }
}
