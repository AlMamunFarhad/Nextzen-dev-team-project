<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory()->create(['role' => 0])->id,
            'name' => $this->faker->name(),
            'specialization' => $this->faker->randomElement(['General', 'Cardiology', 'Dermatology', 'Neurology']),
            'experience' => $this->faker->numberBetween(1, 40),
            'consultation_fee' => $this->faker->randomFloat(2, 100, 1000),
            'bio' => $this->faker->text(50),
            'status' => 1,
        ];
    }
}
