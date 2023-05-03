<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
/**
 * @group Админ
 *
 * @subgroup Амбассадор
 */
class RemoveAmbassadorController extends Controller
{
    /**
     * Удаление роди амбассадор.
     */
    public function __invoke(Request $request, User $user)
    {
        $request->validate([
            'text' => ['required']
        ]);

        $user->is_ambassador = false;

        $user->ambassador = $request->text;

        $user->save();

        return response()->json([
            'message' => 'Ambassador role remove.',
        ], Response::HTTP_CREATED);
    }
}
