<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ReceptionistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'name'=>'Receptionist One',
        'email'=>'reception@example.com',
        'password'=>Hash::make('password'),
        'role'=> User::ROLE_RECEPTIONIST,
        'clinic_id'=> null, // Assign to a clinic if needed
    ]);
    }
}
