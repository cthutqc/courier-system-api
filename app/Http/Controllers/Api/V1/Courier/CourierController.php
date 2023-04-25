<?php

namespace App\Http\Controllers\Api\V1\Courier;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourierControllerStoreRequest;
use App\Http\Requests\CourierControllerUpdateRequest;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourierControllerStoreRequest $request)
    {
        $request->user()->update($request->only('name', 'last_name', 'middle_name'));

        $request->user()->personal_information()->create($request->only('passport_series', 'passport_number', 'passport_issued_by', 'passport_issued_date'));

        $request->user()->contact_information()->create($request->only('region', 'city', 'street', 'house', 'flat'));

        $request->user()->addMedia($request->passport_photo_id)->toMediaCollection('passport_id');

        $request->user()->addMedia($request->passport_photo_address)->toMediaCollection('passport_address');

        return response()->json([
            'success' => 'Courier profile created.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('media');

        $user->load('personal_information');

        $user->load('contact_information');

        return CourierResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourierControllerUpdateRequest $request, User $user)
    {
        $user->update($request->only('name', 'last_name', 'middle_name'));

        $user->personal_information()->update($request->only('passport_series', 'passport_number', 'passport_issued_by', 'passport_issued_date'));

        $user->contact_information()->update($request->only('region', 'city', 'street', 'house', 'flat'));

        $request->user()->addMedia($request->passport_photo_id)->toMediaCollection('passport_id');

        $request->user()->addMedia($request->passport_photo_address)->toMediaCollection('passport_address');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
