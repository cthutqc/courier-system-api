<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssignAmbassadorRoleAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user)
    {
        if(!$user->hasRole('customer'))
            abort(403);

        $user->assignRole('ambassador');

        return response()->json([
            'message' => 'Ambassador role set.',
        ], Response::HTTP_CREATED);
    }
}
