<?php

namespace Tests\Feature\Amin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssignAmbassadorRoleActionTest extends TestCase
{
    use RefreshDatabase;

    public function testAssignAmbassadorRoleActionTest()
    {
        $user = User::factory()->create();

        $user->assignROle('customer');

        $user->update([
            'active' => true,
        ]);

        $response = $this->actingAs($user)->putJson('/api/v1/admin/users/' . $user->id . '/ambassador');

        $response->assertStatus(201);
    }
}
