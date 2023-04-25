<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create()->each(function ($user){

            $user->active = true;

            $user->assignRole('customer');

            $user->update([
                'name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'middle_name' => fake()->name(),
            ]);

            $user->balance = 10000;

            $user->save();

        });
    }
}
