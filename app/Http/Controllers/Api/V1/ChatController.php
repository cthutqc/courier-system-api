<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConversationRequest;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Чат
 *
 * @subgroup Заказ
 */
class ChatController extends Controller
{
    /**
     * Список чатов.
     */
    public function index()
    {
        $conversations = Conversation::where('user_id', auth()->user()->id)
            ->orWhere('recipient_id', auth()->user()->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json(['conversations' => $conversations]);
    }

    /**
     * Чат.
     */
    public function show(Conversation $conversation)
    {
        if ($conversation->user_id != auth()->user()->id && $conversation->recipient_id != auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $messages = $conversation->messages()->with('user')->get();

        return response()->json(['messages' => $messages]);
    }

    /**
     * Создание чата.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'recipient_id' => 'required|exists:users,id',
        ]);

        $conversation = Conversation::create([
            'user_id' => auth()->user()->id,
            'recipient_id' => $validatedData['recipient_id'],
        ]);

        return response()->json(['conversation' => $conversation], Response::HTTP_CREATED);
    }

    /**
     * Отправка сообщения.
     */
    public function send(Conversation $conversation, ConversationRequest $request)
    {
        if ($conversation->user_id != auth()->user()->id && $conversation->recipient_id != auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $message = $conversation->messages()->create([
            'user_id' => auth()->user()->id,
            'message' => $request->message,
        ]);

        return response()->json(['message' => $message], Response::HTTP_CREATED);

    }
}
