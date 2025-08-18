<?php

use App\Component\Properties\Infrastructure\Http\Handler\CreateServiceHandler;
use App\Component\Properties\Infrastructure\Http\Handler\GetServicesHandler;
use App\Component\Properties\Infrastructure\Http\Handler\UpdateServiceHandler;
use App\Component\Properties\Infrastructure\Http\Handler\DeleteServiceHandler;
use Illuminate\Support\Facades\Route;

Route::prefix('properties')->group(function () {
    Route::prefix('services')->group(function () {
        Route::post('/', CreateServiceHandler::class);
        Route::get('/', GetServicesHandler::class);
        Route::put('/{id}', UpdateServiceHandler::class);
        Route::delete('/{id}', DeleteServiceHandler::class);
    });
});


