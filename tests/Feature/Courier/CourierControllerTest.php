<?php

namespace Tests\Feature\Courier;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourierControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCourierControllerStore()
    {
        $user = User::create([
            'email' => fake()->unique()->email,
            'phone' => '00000000000',
            'password' => 'password1',
            'password_confirmation' => 'password1'
        ]);

        $user->active = true;

        $user->save();

        $user->assignRole('courier');

        $response = $this->actingAs($user)->postJson('api/v1/courier/profile', [
            'name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'middle_name' => fake()->name,
            'passport_series' => '1234',
            'passport_number' => '123456',
            'passport_issued_by' => fake()->address,
            'passport_issued_date' => '00.00.0000',
            'region' => fake()->country,
            'city' => fake()->city,
            'street' => fake()->streetName,
            'house' => '213',
            'flat' => '23',
            'passport_photo_id' => fake()->image,
            'passport_photo_address' => fake()->image,
        ]);

        return $response->assertStatus(201);
    }
}
