<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Чат
 *
 * @subgroup Поддержка
 */
class SupportController extends ChatController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $conversation = Conversation::create([
            'user_id' => $request->user()->id,
            'recipient_id' => User::role('admin')->inRandomOrder()->first()->id,
        ]);

        return response()->json(['conversation' => $conversation], Response::HTTP_CREATED);
    }
}
