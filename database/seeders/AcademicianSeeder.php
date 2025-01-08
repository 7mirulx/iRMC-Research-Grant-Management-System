<?php

namespace Database\Seeders;

use App\Models\Academician;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AcademicianSeeder extends Seeder
{
    public function run(): void
    {
        // Create John Doe
        $john = Academician::create([
            'staff_number' => 'STF001',
            'name' => 'Dr. John Doe',
            'email' => 'john.doe@irmc.uniten.edu.my',
            'position' => 'Professor',
            'college' => 'College of Engineering',
            'department' => 'Electrical Engineering'
        ]);

        User::create([
            'name' => 'Dr. John Doe',
            'email' => 'john.doe@irmc.uniten.edu.my',
            'password' => Hash::make('password'),
            'role' => 'academician',
            'academician_id' => $john->id
        ]);

        // Create 4 more academicians
        $academicians = [
            [
                'staff_number' => 'STF002',
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@irmc.uniten.edu.my',
                'position' => 'Associate Professor',
                'college' => 'College of Engineering',
                'department' => 'Electrical Engineering'
            ],
            [
                'staff_number' => 'STF003',
                'name' => 'Dr. Michael Chen',
                'email' => 'michael.chen@irmc.uniten.edu.my',
                'position' => 'Senior Lecturer',
                'college' => 'College of Engineering',
                'department' => 'Mechanical Engineering'
            ],
            [
                'staff_number' => 'STF004',
                'name' => 'Dr. Lisa Wong',
                'email' => 'lisa.wong@irmc.uniten.edu.my',
                'position' => 'Professor',
                'college' => 'College of Engineering',
                'department' => 'Chemical Engineering'
            ],
            [
                'staff_number' => 'STF005',
                'name' => 'Dr. David Kim',
                'email' => 'david.kim@irmc.uniten.edu.my',
                'position' => 'Associate Professor',
                'college' => 'College of Engineering',
                'department' => 'Civil Engineering'
            ]
        ];

        foreach ($academicians as $data) {
            $academician = Academician::create([
                'staff_number' => $data['staff_number'],
                'name' => $data['name'],
                'email' => $data['email'],
                'position' => $data['position'],
                'college' => $data['college'],
                'department' => $data['department']
            ]);

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'academician',
                'academician_id' => $academician->id
            ]);
        }
    }
} 