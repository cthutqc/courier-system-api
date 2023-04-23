<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateCourier()
    {
        User::factory()->create();

        $user = User::find(1);

        $user->assignRole('admin');

        User::factory()->create();

        $customer = User::find(2)->assignRole('customer');

        $response = $this->actingAs($user)->putJson('/api/v1/admin/customers/' . $customer->id, [
            'name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'sure_name' => fake()->name,
            'email' => fake()->unique()->email(),
            'phone' => fake()->unique()->phoneNumber,
            'active' => true,
        ]);

        $response->assertStatus(201);
    }

    public function testDestroyCourier()
    {
        User::factory()->create();

        $user = User::find(1);

        $user->assignRole('admin');

        User::factory()->create();

        $customer = User::find(2)->assignRole('customer');

        $response = $this->actingAs($user)->delete('/api/v1/admin/customers/' . $customer->id);

        $response->assertStatus(200);

    }
}
