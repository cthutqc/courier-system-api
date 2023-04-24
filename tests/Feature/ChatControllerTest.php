<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChatControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateChat()
    {
        User::factory(2)->create();

        $courier = User::find(1);

        $courier->assignRole('courier');

        $courier->active = true;

        $courier->save();

        $customer = User::find(2);

        $customer->assignRole('customer');

        $customer->active = true;

        $customer->save();

        $response = $this->actingAs($customer)->postJson('/api/v1/conversations', [
            'recipient_id' => $courier->id
        ]);

        $response->assertStatus(201);
    }

    public function testSendMessage()
    {
        User::factory(2)->create();

        $courier = User::find(1);

        $courier->assignRole('courier');

        $courier->active = true;

        $courier->save();

        $customer = User::find(2);

        $customer->assignRole('customer');

        $customer->active = true;

        $customer->save();

        $conversation = Conversation::create([
            'user_id' => $customer->id,
            'recipient_id' => $courier->id,
        ]);

        $response = $this->actingAs($customer)->postJson('/api/v1/conversations/' . $conversation->id . '/send', [
            'message' => 'test',
        ]);

        $response->assertStatus(201);

    }
}
