<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourierUpdateRequest;
use App\Http\Resources\CourierResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CourierResource::collection(User::role('courier')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('courier_information');

        $user->load('courier_location');

        return CourierResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourierUpdateRequest $request, User $user)
    {
        $user->update($request->only('name', 'last_name', 'sure_name', 'email', 'phone'));

        $user->courier_information()->update($request->only('address', 'passport_series', 'passport_number', 'passport_issued_by', 'passport_issued_date'));

        return response()->json([
            'success' => 'Courier updated.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'success' => 'Courier deleted.',
        ], Response::HTTP_OK);
    }

    public function count()
    {
        return User::role('courier')->count();
    }
}
