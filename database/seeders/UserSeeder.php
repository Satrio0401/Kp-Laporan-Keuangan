<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'password' => Hash::make('password123'), // Gantilah dengan password yang lebih aman
        ]);

        User::create([
            'name' => 'User1',
            'password' => Hash::make('password123'),
        ]);
    }
}