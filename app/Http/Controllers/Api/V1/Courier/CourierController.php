<?php

namespace App\Http\Controllers\Api\V1\Courier;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourierUpdateRequest;
use App\Http\Resources\CourierResource;
use App\Models\Courier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
/**
 * @group Курьер
 *
 * @subgroup Настройки
 */
class CourierController extends Controller
{
    /**
     * Создание личных данных курьера.
     */
    public function store(Request $request)
    {
        $request->user()->update($request->only('name', 'last_name', 'middle_name'));

        $request->user()->personal_information()->create($request->only('passport_series', 'passport_number', 'passport_issued_by', 'passport_issued_date'));

        $request->user()->contact_information()->create($request->only('region', 'city', 'street', 'house', 'flat'));

        //$request->user()->addMedia($request->passport_photo_id)->toMediaCollection('passport_id');

        // $request->user()->addMedia($request->passport_photo_address)->toMediaCollection('passport_address');

        return response()->json([
            'success' => 'Courier profile created.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Информация о курьере.
     */
    public function show()
    {
        auth()->user()->load('media');

        auth()->user()->load('personal_information');

        auth()->user()->load('contact_information');

        return CourierResource::make(auth()->user());
    }

    /**
     * Обновление информации о курьере.
     */
    public function update(CourierUpdateRequest $request)
    {
        auth()->user()->update($request->only('name', 'last_name', 'middle_name'));

        auth()->user()->personal_information()->update($request->only('passport_series', 'passport_number', 'passport_issued_by', 'passport_issued_date'));

        auth()->user()->contact_information()->update($request->only('region', 'city', 'street', 'house', 'flat'));

        auth()->user()->save();

        //$request->user()->addMedia($request->passport_photo_id)->toMediaCollection('passport_id');

        // $request->user()->addMedia($request->passport_photo_address)->toMediaCollection('passport_address');

        return response()->json([
            'success' => 'Courier profile updated.',
        ], Response::HTTP_CREATED);
    }
}
