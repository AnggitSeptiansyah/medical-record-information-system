<?php

namespace Database\Factories;

use App\Models\Patient;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => Patient::factory(),
            'visit_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'complaint' => fake()->sentence(10),
            'diagnosis' => fake()->sentence(8),
            'treatment' => fake()->paragraph(2),
            'prescription' => fake()->sentence(6),
            'notes' => fake()->optional()->paragraph(),
            'payment_amount' => fake()->numberBetween(5, 50) * 10000,
            'payment_status' => fake()->randomElement(['unpaid', 'paid']),
        ];
    }
}
