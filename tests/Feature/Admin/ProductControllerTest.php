<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testProductStore()
    {
        $user = User::factory()->create();

        $user->assignRole('admin');

        $response = $this->actingAs($user)->postJson('/api/v1/admin/products/', [
            'name' => fake()->firstName,
            'text' => fake()->text(),
            'price' => fake()->numberBetween([10000, 15000]),
            'active' => true,
            ]);

        $response->assertStatus(201);
    }

    public function testProductUpdate()
    {
        $user = User::factory()->create();

        $user->assignRole('admin');

        $product = Product::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/admin/products/' . $product->id, [
            'name' => fake()->firstName,
            'text' => fake()->text(),
            'price' => fake()->numberBetween([10000, 15000]),
            'active' => true,
        ]);

        $response->assertStatus(201);
    }
}
