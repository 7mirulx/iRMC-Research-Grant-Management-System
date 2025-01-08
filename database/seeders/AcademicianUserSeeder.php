<?php

namespace Database\Seeders;

use App\Models\Academician;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AcademicianUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test academician
        $academician = Academician::create([
            'staff_number' => 'STF001',
            'name' => 'Dr. John Doe',
            'email' => 'john.doe@irmc.uniten.edu.my',
            'position' => 'Professor',
            'college' => 'College of Engineering',
            'department' => 'Electrical Engineering'
        ]);

        // Create user account for the academician
        User::create([
            'name' => $academician->name,
            'email' => $academician->email,
            'password' => Hash::make('password'),
            'role' => 'academician',
            'academician_id' => $academician->id
        ]);
    }
} 