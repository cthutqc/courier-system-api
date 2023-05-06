<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Password;
/**
 * @group Аутентификация
 */
class RegisterController extends Controller
{
    /**
     * Регистрация.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:11', 'max:11', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->numbers()],
        ]);

        $user = User::create([
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
        ]);

        event(new UserRegistered($user));

        $device = substr($request->userAgent() ?? '', 0, 255);

        $expiresAt = $request->remember ? null : now()->addMinutes(config('session.lifetime'));

        return response()->json([
            'access_token' => $user->createToken($device, expiresAt: $expiresAt)->plainTextToken,
            'message' => 'Success.',
        ], Response::HTTP_CREATED);
    }
}
