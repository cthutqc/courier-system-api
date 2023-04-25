<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'role' => ['required']
        ]);

        $request->user()->assignRole($request->role);

        return response()->json([
            'success' => 'Role is set.'
        ], Response::HTTP_CREATED);
    }
}
