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

    Route::post('auth/password-change', \App\Http\Controllers\Api\V1\Auth\PasswordChangeController::class);

    Route::middleware(\App\Http\Middleware\ActiveUser::class)->group(function (){

        Route::post('auth/role', \App\Http\Controllers\Api\V1\Auth\RoleController::class);

        Route::post('auth/logout', \App\Http\Controllers\Api\V1\Auth\LogoutController::class);

        Route::apiResource('conversations', \App\Http\Controllers\Api\V1\ChatController::class);

        Route::post('/conversations/support', [\App\Http\Controllers\Api\V1\SupportController::class, 'store']);

        Route::post('/conversations/{conversation}/send', [\App\Http\Controllers\Api\V1\ChatController::class, 'send']);

        Route::prefix('customer')->middleware(\App\Http\Middleware\IsCustomer::class)->group(function (){

            Route::post('settings', [\App\Http\Controllers\Api\V1\Customer\SettingController::class, 'store']);

            Route::post('settings/{customer}', [\App\Http\Controllers\Api\V1\Customer\SettingController::class, 'update']);

            Route::get('settings/{customer}', [\App\Http\Controllers\Api\V1\Customer\SettingController::class, 'show']);

            Route::apiResource('products', \App\Http\Controllers\Api\V1\Customer\ProductController::class);

            Route::apiResource('partners', \App\Http\Controllers\Api\V1\Customer\PartnerController::class);

            Route::apiResource('orders', \App\Http\Controllers\Api\V1\Customer\OrderController::class);

            Route::post('recharge-balance', \App\Http\Controllers\Api\V1\Customer\RechargeBalanceController::class);

            Route::post('orders/{order}/rate', [\App\Http\Controllers\Api\V1\Customer\OrderController::class, 'rate']);

            Route::post('orders/{order}/cancel', [\App\Http\Controllers\Api\V1\Customer\OrderController::class, 'cancel']);

            Route::get('category_products', \App\Http\Controllers\Api\V1\Customer\CategoryProductController::class);

        });

        Route::prefix('courier')->middleware(\App\Http\Middleware\IsCourier::class)->group(function (){

            Route::get('/', \App\Http\Controllers\Api\V1\Courier\DashboardController::class);

            Route::post('settings', [\App\Http\Controllers\Api\V1\Courier\SettingController::class, 'store']);

            Route::post('settings/{courier}', [\App\Http\Controllers\Api\V1\Courier\SettingController::class, 'update']);

            Route::get('settings/{courier}', [\App\Http\Controllers\Api\V1\Courier\SettingController::class, 'show']);

            Route::get('ratings', \App\Http\Controllers\Api\V1\Courier\RatingsController::class);

            Route::get('orders', [\App\Http\Controllers\Api\V1\Courier\OrdersController::class, 'index']);

            Route::get('orders/{order}', [\App\Http\Controllers\Api\V1\Courier\OrdersController::class, 'show']);

            Route::put('orders/{order}/start', [\App\Http\Controllers\Api\V1\Courier\OrdersController::class, 'start']);

            Route::put('orders/{order}/stop', [\App\Http\Controllers\Api\V1\Courier\OrdersController::class, 'stop']);

        });

        Route::prefix('admin')->middleware(\App\Http\Middleware\IsAdmin::class)->group(function (){

            Route::apiResource('orders', \App\Http\Controllers\Api\V1\Admin\OrderController::class);

            Route::put('orders/{order}/accepted', [\App\Http\Controllers\Api\V1\Admin\OrderController::class, 'accepted']);

            Route::apiResource('products', \App\Http\Controllers\Api\V1\Admin\ProductController::class);

            Route::apiResource('couriers', \App\Http\Controllers\Api\V1\Admin\CourierController::class);

            Route::get('couriers/count', [\App\Http\Controllers\Api\V1\Admin\CourierController::class, 'count']);

            Route::apiResource('customers', \App\Http\Controllers\Api\V1\Admin\CustomerController::class);

            Route::get('customers/count', [\App\Http\Controllers\Api\V1\Admin\CustomerController::class, 'count']);

            Route::put('customers/{user}/ambassador', \App\Http\Controllers\Api\V1\Admin\AssignAmbassadorRoleController::class);

            Route::put('customers/{user}/ambassador/remove', \App\Http\Controllers\Api\V1\Admin\RemoveAmbassadorRoleController::class);
        });

    });

});

Route::post('auth/register', \App\Http\Controllers\Api\V1\Auth\RegisterController::class);

Route::post('auth/login', \App\Http\Controllers\Api\V1\Auth\LoginController::class)->middleware('throttle:10');

Route::post('auth/forgot', \App\Http\Controllers\Api\V1\Auth\PasswordForgotController::class);

Route::post('auth/reset', \App\Http\Controllers\Api\V1\Auth\PasswordResetController::class);

Route::get('qrcode', \App\Http\Controllers\QrGenerate::class);
