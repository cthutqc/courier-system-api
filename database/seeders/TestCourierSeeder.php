<?php

namespace Database\Seeders;

use App\Models\ContactInformation;
use App\Models\Courier;
use App\Models\PersonalInformation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestCourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courier = Courier::factory()->create([
            'name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'middle_name' => fake()->name,
            'email' => 'courier@test.com',
            'phone' => fake()->unique()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => 'password',
            'remember_token' => Str::random(10),
            'type' => 'courier',
            'active' => true,
        ]);

        $courier->contact_information()->save(ContactInformation::factory()->create());

        $courier->personal_information()->save(PersonalInformation::factory()->create());

    }
}
