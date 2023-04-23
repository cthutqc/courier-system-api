<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::post('auth/confirm', \App\Http\Controllers\Api\V1\Auth\ConfirmController::class);

    Route::middleware('user.active')->group(function (){

        Route::post('auth/logout', \App\Http\Controllers\Api\V1\Auth\LogoutController::class);

        Route::prefix('customer')->group(function (){

            Route::get('orders', \App\Http\Controllers\Api\V1\Customer\ShowAllOrdersController::class);

            Route::get('orders/{order}', \App\Http\Controllers\Api\V1\Customer\ShowOrderController::class);

            Route::post('orders/create', \App\Http\Controllers\Api\V1\Customer\CreateOrderController::class);

        });

        Route::prefix('courier')->group(function (){

            Route::get('orders', \App\Http\Controllers\Api\V1\Courier\ShowAllOrdersController::class);

            Route::get('orders/{order}/start', \App\Http\Controllers\Api\V1\Courier\ShowOrderController::class);

            Route::put('orders/{order}/start', \App\Http\Controllers\Api\V1\Courier\StartOrderController::class);

            Route::put('orders/{order}/finished', \App\Http\Controllers\Api\V1\Courier\FinishOrderController::class);

        });

        Route::prefix('admin')->group(function (){


            Route::apiResource('orders', \App\Http\Controllers\Api\V1\Admin\OrderController::class);

            Route::apiResource('products', \App\Http\Controllers\Api\V1\Admin\ProductController::class);

            Route::apiResource('couriers', \App\Http\Controllers\Api\V1\Admin\CourierController::class);

            Route::apiResource('customers', \App\Http\Controllers\Api\V1\Admin\CustomerController::class);

            Route::put('orders/{order}/accepted', [\App\Http\Controllers\Api\V1\Admin\OrderController::class, 'accepted']);

            Route::put('users/{user}/ambassador', \App\Http\Controllers\Api\V1\Admin\AssignAmbassadorRoleController::class);

            Route::put('users/{user}/ambassador/remove', \App\Http\Controllers\Api\V1\Admin\RemoveAmbassadorRoleController::class);

        });

    });

});

Route::post('auth/register', \App\Http\Controllers\Api\V1\Auth\RegisterController::class);

Route::post('auth/login', \App\Http\Controllers\Api\V1\Auth\LoginController::class)->middleware('throttle:10');

Route::post('auth/forgot', \App\Http\Controllers\Api\V1\Auth\PassportForgotController::class);

Route::post('auth/reset', \App\Http\Controllers\Api\V1\Auth\PassportResetController::class);
