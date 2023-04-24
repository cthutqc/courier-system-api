<?php

namespace Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    public function UserCanLogout()
    {
        $user = User::factory()->create();

        $user->assignRole('customer');

        $user->active = true;

        $user->save();

        $response = $this->postJson('/api/v1/auth/logout');

        $response->assertStatus(201);
    }
}
