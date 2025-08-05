<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'payments',
], function () {
    // Promo code routes
    Route::post('apply-promo-code', \App\Component\Payments\Infrastructure\Http\Handler\ApplyPromoCodeHandler::class);
    
    // Subscription routes (require authentication)
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::post('subscribe', \App\Component\Payments\Infrastructure\Http\Handler\SubscribeToPackageHandler::class);
        Route::get('subscriptions', \App\Component\Payments\Infrastructure\Http\Handler\GetUserSubscriptionsHandler::class);
    });
}); 