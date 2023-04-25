<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAssignRole()
    {
        $user = User::factory()->create();

        $user->active = true;

        $user->save();

        $response = $this->actingAs($user)->postJson('/api/v1/auth/role', [
            'role' => 'courier',
        ]);

        return $response->assertStatus(201);
    }
}
