<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@irmc.uniten.edu.my',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'academician_id' => null
        ]);
    }
} 