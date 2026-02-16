<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
            'email' => 'admin@gmail.com',
            'role' => 0,
            'password' => Hash::make('12345678'),
        ]);
        User::create([
            'name' => 'Doctor',
            'email' => 'doctor@gmail.com',
            'role' => 1,
            'password' => Hash::make('12345678'),
        ]);
        User::create([
            'name' => 'Patient',
            'email' => 'patient@gmail.com',
            'role' => 2,
            'password' => Hash::make('12345678'),
        ]);
        User::create([
            'name' => 'Receptionist',
            'email' => 'receptionist@gmail.com',
            'role' => 3,
            'password' => Hash::make('12345678'),
        ]);
    }
}
