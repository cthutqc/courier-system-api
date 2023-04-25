<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = ['Документы', 'СНИЛС', 'Военный билет'];


        return [
            'name' => $products[rand(0, count($products)-1)],
            'address_from' => fake()->address(),
            'address_to' => fake()->address(),
            'text' => fake()->text,
            'desired_pick_up_date' => fake()->dateTime,
            'desired_delivery_date' => fake()->dateTime,
        ];
    }
}
