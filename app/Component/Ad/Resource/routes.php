<?php

use App\Component\Ad\Infrastructure\Http\Handler\CheckAdLicenseHandler;
use App\Component\Ad\Infrastructure\Http\Handler\GetDataFilterHandler;
use App\Component\Ad\Infrastructure\Http\Handler\StoreBuyAdHandler;
use App\Component\Ad\Infrastructure\Http\Handler\StoreSellAdHandler;
use App\Component\Ad\Infrastructure\Http\Handler\ListAdHandler;
use App\Component\Ad\Infrastructure\Http\Handler\ToggleFavoriteHandler;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'ads',

],function (){
    Route::get('get-data-filter', GetDataFilterHandler::class);

    Route::post('check-license', CheckAdLicenseHandler::class)->middleware('auth:sanctum');
    Route::post('store-sell-ads', StoreSellAdHandler::class)->middleware('auth:sanctum');
    Route::post('store-buy-ads', StoreBuyAdHandler::class)->middleware('auth:sanctum');


    Route::get('list-sell-ads', ListAdHandler::class)->middleware('optional.auth');
    Route::post('{ad}/toggle-favorite', ToggleFavoriteHandler::class)->middleware('auth:sanctum');


    //    Route::post('store-request-ads', StoreRequestAdHandler::class)->middleware('auth:sanctum');

});
