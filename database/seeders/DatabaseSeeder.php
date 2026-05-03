<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tutor;
use App\Models\ClassCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create Owner & Admin
        User::create([
            'name' => 'Owner',
            'email' => 'owner@zola.com',
            'password' => bcrypt('123'),
            'role' => 'owner',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@zola.com',
            'password' => bcrypt('123'),
            'role' => 'admin',
        ]);

        // Create Tutors
        $tutors = ['Ms. Latifah', 'Ms. Yelli', 'Ms. Desti', 'Ms. Ayu'];
        foreach ($tutors as $name) {
            Tutor::create(['name' => $name]);
        }

        // Create Class Codes
        $programs = [
            ['program' => 'Pra Calistung', 'prefix' => 'PC', 'count' => 5, 'duration' => 90],
            ['program' => 'Bahasa Inggris', 'prefix' => 'B', 'count' => 5, 'duration' => 90],
            ['program' => 'Semapel', 'prefix' => 'S', 'count' => 5, 'duration' => 90],
            ['program' => 'Calistung', 'prefix' => 'C', 'count' => 5, 'duration' => 90],
            ['program' => 'Mengaji', 'prefix' => 'M', 'count' => 5, 'duration' => 60],
        ];

        foreach ($programs as $prog) {
            for ($i = 1; $i <= $prog['count']; $i++) {
                ClassCode::create([
                    'program' => $prog['program'],
                    'code' => $prog['prefix'] . $i,
                    'duration_minutes' => $prog['duration'],
                ]);
            }
        }
    }
}
