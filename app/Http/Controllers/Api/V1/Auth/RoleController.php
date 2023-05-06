<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Аутентификация
 */
class RoleController extends Controller
{
    /**
     * Выбор роли - заказчик/курьер.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'role' => ['required'],
        ]);

        $request->user()->type = $request->role;

        $request->user()->save();

        return response()->json([
            'success' => 'Role is set.',
        ], Response::HTTP_CREATED);
    }
}
