<?php

namespace Tests\Feature\Customer;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RateOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRateOrder()
    {
        $user = User::factory()->create();

        $user->update(['active' => true]);

        $user->assignRole('customer');

        $user->balance = 150000;

        $user->save();

        $order = Order::create([
            'address_to' => fake()->address(),
            'address_from' => fake()->address(),
            'desired_pick_up_date' => fake()->time,
            'desired_delivery_date' => fake()->time,
            'text' => fake()->text,
        ]);

        $order->customer()->associate($user);

        Product::create([
            'name' => fake()->firstName,
            'text' => fake()->text(),
            'price' => fake()->numberBetween([10000, 15000]),
            'active' => true,
        ]);

        $order->products()->attach(1);

        $courier = User::factory()->create();

        $courier->update(['active' => true]);

        $courier->assignRole('courier');

        $order->courier()->associate($courier);

        $order->update([
            'price' => $order->orderPrice(),
            'approximate_time' => fake()->time,
            'start_at' => now()
        ]);

        $order->finish();

        $response = $this->actingAs($user)->postJson('/api/v1/customer/orders/' . $order->id . '/rate', [
            'score' => 5,
        ]);

        $response->assertStatus(201);
    }
}
