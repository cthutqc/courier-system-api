<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerSettingStoreRequest;
use App\Http\Resources\CourierResource;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
/**
 * @group Заказчик
 *
 * @subgroup Настройки
 */
class CustomerController extends Controller
{
    /**
     * Заполнение информации о заказчике.
     */
    public function store(CustomerSettingStoreRequest $request)
    {
        $request->user()->update($request->only('name', 'last_name', 'middle_name'));

        $request->user()->contact_information()->create($request->only('region', 'city', 'street', 'house', 'flat'));

        //$request->user()->addMedia($request->passport_photo_id)->toMediaCollection('passport_id');

        // $request->user()->addMedia($request->passport_photo_address)->toMediaCollection('passport_address');

        return response()->json([
            'customer' => Customer::with('contact_information')->where('id', $request->user()->id)->first(),
            'success' => 'Customer profile created.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Информация о заказчике.
     */
    public function show()
    {
        auth()->user()->load('media');

        auth()->user()->load('contact_information');

        return CustomerResource::make(auth()->user());
    }

    /**
     * Обновление информации о заказчике.
     */
    public function update(CustomerSettingStoreRequest $request)
    {
        auth()->user()->update($request->only('name', 'last_name', 'middle_name'));

        auth()->user()->contact_information()->update($request->only('region', 'city', 'street', 'house', 'flat'));

        auth()->user()->save();

        return response()->json([
            'success' => 'Customer profile updated.',
        ], Response::HTTP_CREATED);
    }
}
