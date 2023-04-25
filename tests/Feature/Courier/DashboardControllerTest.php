<?php

namespace Tests\Feature\Courier;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCourierDashboard()
    {
        $user = User::factory(100)->create()->each(function ($user){
            $user->active = true;
            $user->save();

            $user->assignRole('courier');

            $user->update([
                'name' => fake()->firstName,
                'last_name' => fake()->lastName,
                'middle_name' => fake()->name,
            ]);

            $user->personal_information()->create([
                'passport_series' => '1234',
                'passport_number' => '123456',
                'passport_issued_by' => fake()->address,
                'passport_issued_date' => '00.00.0000',
            ]);

            $user->contact_information()->create([
                'region' => fake()->country,
                'city' => fake()->city,
                'street' => fake()->streetName,
                'house' => '213',
                'flat' => '23',
            ]);
        });
    }
}
