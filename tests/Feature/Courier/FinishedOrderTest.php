<?php

namespace Courier;

use App\Models\Balance;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinishedOrderTest extends TestCase
{
    use RefreshDatabase;

    public function testFinishedOrderAction()
    {
        $customer = User::factory()->create();

        $customer->update([
            'balance' => 10000,
        ]);

        $order = Order::create([
            'address_to' => fake()->address(),
            'address_from' => fake()->address(),
            'desired_pick_up_date' => fake()->time,
            'desired_delivery_date' => fake()->time,
            'text' => fake()->text,
        ]);

        $order->customer()->associate($customer);

        $order->products()->attach(1);

        $courier = User::factory()->create();

        $courier->update(['active' => true]);

        $courier->assignRole('courier');

        $order->courier()->associate($courier);

        $order->update([
            'price' => $order->products()->sum('price'),
            'approximate_time' => fake()->time,
            'start_at' => now()
        ]);

        $response = $this->actingAs($courier)->putJson('/api/v1/courier/orders/' . $order->id . '/finished', [
            'stop_at' => now()
        ]);

        $response->assertStatus(201);
}
}
