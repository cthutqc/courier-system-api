<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateSupportRequest()
    {
        User::factory(2)->create();

        $admin = User::find(1);

        $admin->assignRole('admin');

        $admin->active = true;

        $admin->save();

        $customer = User::find(2);

        $customer->assignRole('customer');

        $customer->active = true;

        $customer->save();

        $response = $this->actingAs($customer)->postJson('/api/v1/conversations/support', [
            'recipient_id' => $admin->id
        ]);

        $response->assertStatus(201);
    }
}
