<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

/**
 * @group Аутентификация
 */
class PasswordChangeController extends Controller
{
    /**
     * Смена пароля.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->numbers()],
        ]);

        if (! Hash::check($request->old_password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'error' => ['Wrong old password.'],
            ]);
        }

        auth()->user()->update([
            'password' => $request->password,
        ]);

        return response()->json([
            'success' => 'Password changed',
        ], Response::HTTP_CREATED);
    }
}
