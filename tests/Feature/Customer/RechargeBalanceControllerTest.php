<?php

namespace Tests\Feature\Customer;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RechargeBalanceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRechargeBalance()
    {
        $user = User::factory()->create();

        $user->update(['active' => true]);

        $user->assignRole('customer');

        $response = $this->actingAs($user)->postJson('/api/v1/customer/recharge-balance', [
            'amount' => 12000
        ]);

        $response->assertStatus(201);
    }
}
