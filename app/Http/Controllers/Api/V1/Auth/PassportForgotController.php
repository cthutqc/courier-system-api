<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
/**
 * @group Auth
 */
class PassportForgotController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        Password::sendResetLink(['email' => $request->email]);

        return response()->json([
            'success' => 'Password reset link send to your email.',
        ], Response::HTTP_CREATED);
    }
}
