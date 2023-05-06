<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;

/**
 * @group Аутентификация
 */
class PasswordResetController extends Controller
{
    /**
     * Сброс пароля.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required',
        ]);

        Password::reset(
            $request->only(['token', 'email', 'password']),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password,
                ])->setRememberToken(\Str::random(60));

                $user->save();
            }
        );

        return response()->json([
            'success' => 'Your reset your password.',
        ], Response::HTTP_CREATED);
    }
}
