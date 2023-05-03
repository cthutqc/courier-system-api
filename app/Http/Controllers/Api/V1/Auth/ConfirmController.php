<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Events\AccountConfirmed;
use App\Http\Controllers\Controller;
use App\Models\ConfirmCode;
use App\Notifications\AccountConfirmedNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
/**
 * @group Аутентификация
 */
class ConfirmController extends Controller
{
    /**
     * Подтверждение кода.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'code' => ['required'],
        ]);

        $code = ConfirmCode::query()
            ->where('user_id', $request->user()->id)
            ->where('email', $request->user()->email)
            ->whereNull('last_used_at')
            ->first();

        if(Hash::check($request->code, $code->code)) {

            $request->user()->update([
                'active' => true,
            ]);

            $code->update([
                'last_used_at' => now(),
            ]);

            if(app()->isProduction())
                $request->user()->notify(new AccountConfirmedNotification());

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
