<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactInformation>
 */
class ContactInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'region' => fake()->country,
            'city' => fake()->city,
            'street' => fake()->streetAddress,
            'house' => fake()->randomNumber(2),
            'flat' => fake()->randomNumber(3),
        ];
    }
}
