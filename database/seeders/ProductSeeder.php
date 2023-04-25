<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = ['Документы', 'СНИЛС', 'Военный билет'];

        foreach ($products as $product)
        {
            Product::create([
                'name' => $product,
                'price' => fake()->numberBetween(150, 1000),
            ]);
        }
    }
}
