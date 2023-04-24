<?php

namespace Courier;

use App\Models\Balance;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StartOrderTest extends TestCase
{
    use RefreshDatabase;

    public function testStartOrderAction()
    {
        $customer = User::factory()->create();

        $order = Order::create([
            'customer_id' => $customer->id,
            'address_to' => fake()->address(),
            'address_from' => fake()->address(),
            'desired_pick_up_date' => fake()->time,
            'desired_delivery_date' => fake()->time,
            'text' => fake()->text,
        ]);

        $order->products()->attach(1);

        $order->update([
            'price' => $order->products()->sum('price'),
        ]);

        $courier = User::factory()->create();

        $courier->update(['active' => true]);

        $courier->assignRole('courier');

        $response = $this->actingAs($courier)->putJson('/api/v1/courier/orders/' . $order->id . '/start', [
            'start_at' => now()
        ]);

        $response->assertStatus(201);
    }
}
