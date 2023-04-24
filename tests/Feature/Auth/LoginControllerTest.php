<?php

namespace Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function UserCanLogin()
    {
        $user = User::factory()->create();

        $user->assignRole('customer');

        $user->active = true;

        $user->save();

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => $user->password
        ]);

        $response->assertStatus(201);
    }
}
