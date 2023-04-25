<?php

namespace Tests\Feature\Admin;

use App\Models\PersonalInformation;
use App\Models\CourierLocation;
use App\Models\User;
use Database\Factories\PersonalInformationFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourierControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateCourier()
    {
        User::factory()->create();

        $user = User::find(1);

        $user->assignRole('admin');

        User::factory()->create();

        $courier = User::find(2)->assignRole('courier');

        $personal_information = PersonalInformation::factory()->create();

        $personal_information->user()->associate($courier);

        $response = $this->actingAs($user)->putJson('/api/v1/admin/couriers/' . $courier->id, [
            'name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'middle_name' => fake()->name,
            'email' => fake()->unique()->email(),
            'phone' => fake()->unique()->phoneNumber,
            'active' => true,
            'passport_series' => fake()->randomNumber(4),
            'passport_number' => fake()->randomNumber(6),
            'passport_issued_by' => fake()->title,
            'passport_issued_date' => fake()->date('d.m.Y'),
        ]);

        $response->assertStatus(201);
    }

    public function testShowCourier()
    {
        User::factory()->create();

        $user = User::find(1);

        $user->assignRole('admin');

        User::factory()->create();

        $courier = User::find(2)->assignRole('courier');

        $courier_information = PersonalInformation::factory()->create();

        $courier_information->user()->associate($courier);

        $courier_location = CourierLocation::factory()->create();

        $courier_location->courier()->associate($courier);

        $response = $this->actingAs($user)->getJson('/api/v1/admin/couriers/' . $courier->id);

        $response->assertStatus(200);
    }

    public function testDestroyCourier()
    {
        User::factory()->create();

        $user = User::find(1);

        $user->assignRole('admin');

        User::factory()->create();

        $courier = User::find(2)->assignRole('courier');

        $personal_information = PersonalInformation::factory()->create();

        $personal_information->user()->associate($courier);

        $response = $this->actingAs($user)->delete('/api/v1/admin/couriers/' . $courier->id);

        $response->assertStatus(200);

    }
}
