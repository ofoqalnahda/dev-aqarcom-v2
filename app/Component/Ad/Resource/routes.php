<?php

use App\Component\Ad\Infrastructure\Http\Handler\CheckAdLicenseHandler;
use App\Component\Ad\Infrastructure\Http\Handler\StoreSellAdHandler;
use App\Component\Ad\Infrastructure\Http\Handler\StoreRequestAdHandler;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'ads',

],function (){
    Route::post('check-license', CheckAdLicenseHandler::class)->middleware('auth:sanctum');
    Route::post('store-sell-ads', StoreSellAdHandler::class)->middleware('auth:sanctum');
//    Route::post('store-request-ads', StoreRequestAdHandler::class)->middleware('auth:sanctum');

});
