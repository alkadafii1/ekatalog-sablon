<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Matikan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel users
        User::truncate();

        // Nyalakan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Isi ulang data
        User::create([
            'name' => 'User1',
            'email' => 'user@gmail.com',
            'password' => Hash::make('User12345'),
        ]);
    }
}
