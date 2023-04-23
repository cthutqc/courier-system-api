<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssignAmbassadorRoleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAssignAmbassadorTest()
    {
        $user = User::factory()->create();

        $user->assignROle('customer');

        $user->update([
            'active' => true,
        ]);

        $response = $this->actingAs($user)->putJson('/api/v1/admin/customers/' . $user->id . '/ambassador');

        $response->assertStatus(201);
    }
}
