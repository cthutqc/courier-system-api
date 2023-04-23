<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Events\AccountConfirmed;
use App\Http\Controllers\Controller;
use App\Models\ConfirmCode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ConfirmController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'code' => ['required'],
        ]);

        $user = Auth::user();

        $code = ConfirmCode::query()
            ->where('user_id', $user->id)
            ->where('email', $user->email)
            ->whereNull('last_used_at')
            ->first();

        if(Hash::check($request->code, $code->code)) {

            $user->update([
                'active' => true,
            ]);

            $code->update([
                'last_used_at' => now(),
            ]);

            event(new AccountConfirmed($user));

            return response()->json([
                'success' => 'Account confirmed',
            ], Response::HTTP_CREATED);
        } else {
            throw ValidationException::withMessages([
                'error' => 'Incorrect or expired confirmation code',
            ]);
        }
    }
}
