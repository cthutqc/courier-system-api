<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanRegister()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'email' => fake()->unique()->email,
            'phone' => '80000000000',
            'password' => 'password1',
            'password_confirmation' => 'password1',
        ]);

        $response->assertStatus(201);
    }
}
