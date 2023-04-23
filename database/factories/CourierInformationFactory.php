<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourierInformation>
 */
class CourierInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => fake()->streetAddress(),
            'passport_series' => fake()->randomNumber(4),
            'passport_number' => fake()->randomNumber(6),
            'passport_issued_by' => fake()->title,
            'passport_issued_date' => fake()->date('d.m.Y'),
        ];
    }
}
