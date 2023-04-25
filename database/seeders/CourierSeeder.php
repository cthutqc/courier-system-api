<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;

class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create()->each(function ($user){

            $user->active = true;

            $user->save();

            $user->assignRole('courier');

            $user->update([
                'name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'middle_name' => fake()->name(),
            ]);

            $rating = Rating::create([
                'score' => rand(1, 5),
                'review' => fake()->text,
            ]);

            $user->ratings()->save($rating);

        });
    }
}
