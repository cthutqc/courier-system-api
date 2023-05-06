<?php

namespace Database\Seeders;

use App\Models\ContactInformation;
use App\Models\Courier;
use App\Models\PersonalInformation;
use App\Models\Rating;
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
        Courier::factory(10)->create()->each(function ($courier){

            $courier->contact_information()->save(ContactInformation::factory()->create());

            $courier->personal_information()->save(PersonalInformation::factory()->create());

            $rating = Rating::create([
                'score' => rand(1, 5),
                'review' => fake()->text,
            ]);

            $courier->ratings()->save($rating);

            $courier->save();

        });
    }
}
