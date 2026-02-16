<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {

            DB::table('clinics')->insert([
                'name' => fake()->company() . ' Clinic',
                'description' => fake()->paragraph(),
                'logo' => 'logos/' . Str::random(10) . '.png',
                'primary_color' => fake()->hexColor(),
                'secondary_color' => fake()->hexColor(),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
