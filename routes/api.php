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

            Route::get('orders', \App\Http\Controllers\Api\V1\Customer\ShowAllOrdersAction::class);

            Route::get('orders/{order}', \App\Http\Controllers\Api\V1\Customer\ShowOrderAction::class);

            Route::post('orders/create', \App\Http\Controllers\Api\V1\Customer\CreateOrderAction::class);

        });

        Route::prefix('courier')->group(function (){

            Route::get('orders', \App\Http\Controllers\Api\V1\Courier\ShowAllOrdersAction::class);

            Route::get('orders/{order}/start', \App\Http\Controllers\Api\V1\Courier\ShowOrderAction::class);

            Route::put('orders/{order}/start', \App\Http\Controllers\Api\V1\Courier\StartOrderAction::class);

            Route::put('orders/{order}/finished', \App\Http\Controllers\Api\V1\Courier\FinishOrderAction::class);

        });

        Route::prefix('admin')->group(function (){

            Route::get('orders', \App\Http\Controllers\Api\V1\Admin\ShowAllOrdersAction::class);

            Route::get('orders/{order}', \App\Http\Controllers\Api\V1\Admin\ShowOrderAction::class);

            Route::put('orders/{order}/approved', \App\Http\Controllers\Api\V1\Admin\ApprovedOrderAction::class);

            Route::put('users/{user}/ambassador', \App\Http\Controllers\Api\V1\Admin\AssignAmbassadorRoleAction::class);

            Route::put('users/{user}/ambassador/remove', \App\Http\Controllers\Api\V1\Admin\RemoveAmbassadorRoleAction::class);

        });

    });

});

Route::post('auth/register', \App\Http\Controllers\Api\V1\Auth\RegisterController::class);

Route::post('auth/login', \App\Http\Controllers\Api\V1\Auth\LoginController::class)->middleware('throttle:10');

Route::post('auth/forgot', \App\Http\Controllers\Api\V1\Auth\PassportForgotController::class);

Route::post('auth/reset', \App\Http\Controllers\Api\V1\Auth\PassportResetController::class);
