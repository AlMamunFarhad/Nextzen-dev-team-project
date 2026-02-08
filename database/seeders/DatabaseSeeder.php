<?php

namespace Database\Seeders;

use App\Models\Doctor;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Patient;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(UserSeeder::class);
        // Create admin user
        $admin = User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'role' => 0]);


        // Create a doctor user + doctor profile
        $userDoc = User::create(['name' => 'Dr. John', 'email' => 'doc@example.com', 'password' => Hash::make('password'), 'role' => 1]);
        Doctor::create(['user_id' => $userDoc->id, 'specialization' => 'General', 'experience' => 5, 'fee' => 500]);


        // Create a patient user + patient profile
        $userPat = User::create(['name' => 'Patient Zero', 'email' => 'patient@example.com', 'password' => Hash::make('password'), 'role' => 2]);
        Patient::create(['user_id' => $userPat->id, 'age' => 30, 'gender' => 'male']);
    }
}
