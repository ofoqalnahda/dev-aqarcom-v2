<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'settings',
], function () {
    // Settings routes
    Route::get('user', \App\Component\Settings\Infrastructure\Http\Handler\GetUserSettingsHandler::class)
        ->middleware('auth:sanctum');
    Route::post('user', \App\Component\Settings\Infrastructure\Http\Handler\UpdateUserSettingHandler::class)
        ->middleware('auth:sanctum');

    // Withdrawal routes
    Route::get('withdrawals', \App\Component\Settings\Infrastructure\Http\Handler\GetUserWithdrawalsHandler::class)
        ->middleware('auth:sanctum');
    Route::post('withdrawals', \App\Component\Settings\Infrastructure\Http\Handler\CreateWithdrawalHandler::class)
        ->middleware('auth:sanctum');

    // Profit Subscribers routes
    Route::get('profit-subscribers', \App\Component\Settings\Infrastructure\Http\Handler\GetProfitSubscribersHandler::class)
        ->middleware('auth:sanctum');

    // Package routes
    Route::get('packages', \App\Component\Settings\Infrastructure\Http\Handler\GetPackagesHandler::class);

    // Contact routes
    Route::post('contact', \App\Component\Settings\Infrastructure\Http\Handler\CreateContactHandler::class);
    Route::get('contact/my-messages', \App\Component\Settings\Infrastructure\Http\Handler\GetUserContactsHandler::class)
        ->middleware('auth:sanctum');
});
