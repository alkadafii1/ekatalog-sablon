<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'User1',
            'email' => 'user@gmail.com',
            'password' => Hash::make('User12345'), 
        ]);
    }
}
