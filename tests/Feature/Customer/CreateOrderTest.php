<?php

namespace Tests\Feature\Customer;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateOrderAction()
    {
        $user = User::factory()->create();

        $user->update(['active' => true]);

        $user->assignRole('customer');

        $response = $this->actingAs($user)->postJson('/api/v1/customer/orders/create', [
            'address_to' => fake()->address(),
            'address_from' => fake()->address(),
            'desired_pick_up_date' => fake()->time,
            'desired_delivery_date' => fake()->time,
            'text' => fake()->text,
            'products' => [1, 2],
        ]);

        $response->assertStatus(201);
    }
}
