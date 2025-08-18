<?php

use App\Component\Ad\Infrastructure\Http\Handler\CheckAdLicenseHandler;
use App\Component\Ad\Infrastructure\Http\Handler\Constants\Geography\GetCityHandler;
use App\Component\Ad\Infrastructure\Http\Handler\Constants\Geography\GetNeighborhoodHandler;
use App\Component\Ad\Infrastructure\Http\Handler\Constants\Geography\GetRegionHandler;
use App\Component\Ad\Infrastructure\Http\Handler\Constants\Geography\GetRegionMapHandler;
use App\Component\Ad\Infrastructure\Http\Handler\Constants\GetAdTypeHandler;
use App\Component\Ad\Infrastructure\Http\Handler\Constants\GetEstateTypeHandler;
use App\Component\Ad\Infrastructure\Http\Handler\Constants\GetPropertyUtilityHandler;
use App\Component\Ad\Infrastructure\Http\Handler\Constants\GetReasonHandler;
use App\Component\Ad\Infrastructure\Http\Handler\Constants\GetUsageTypeHandler;
use App\Component\Ad\Infrastructure\Http\Handler\GetDataFilterHandler;
use App\Component\Ad\Infrastructure\Http\Handler\ListAdBuyHandler;
use App\Component\Ad\Infrastructure\Http\Handler\ShowAdHandler;
use App\Component\Ad\Infrastructure\Http\Handler\ShowBuyAdHandler;
use App\Component\Ad\Infrastructure\Http\Handler\StoreBuyAdHandler;
use App\Component\Ad\Infrastructure\Http\Handler\StoreSellAdHandler;
use App\Component\Ad\Infrastructure\Http\Handler\ListAdHandler;
use App\Component\Ad\Infrastructure\Http\Handler\HomeAdHandler;
use App\Component\Ad\Infrastructure\Http\Handler\StoryAdHandler;
use App\Component\Ad\Infrastructure\Http\Handler\ToggleFavoriteHandler;
use App\Component\Ad\Infrastructure\Http\Handler\ToggleViewHandler;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'ads',

],function (){
    Route::get('get-data-filter', GetDataFilterHandler::class);

    Route::post('check-license', CheckAdLicenseHandler::class)->middleware('auth:sanctum');
    Route::post('store-sell-ads', StoreSellAdHandler::class)->middleware('auth:sanctum');
    Route::post('store-buy-ads', StoreBuyAdHandler::class)->middleware('auth:sanctum');


    Route::post('{ad}/toggle-favorite', ToggleFavoriteHandler::class)->middleware('auth:sanctum');
    Route::post('{ad}/toggle-view', ToggleViewHandler::class)->middleware('auth:sanctum');
    Route::get('list-sell-ads', ListAdHandler::class)->middleware('optional.auth');
    Route::get('list-buy-ads', ListAdBuyHandler::class)->middleware('optional.auth');

    Route::get('list-story-ads', StoryAdHandler::class)->middleware('optional.auth');
    Route::get('show/sell/{slug}', ShowAdHandler::class)->middleware('optional.auth');
    Route::get('show/buy/{slug}', ShowBuyAdHandler::class)->middleware('optional.auth');
});
Route::get('home', HomeAdHandler::class)->middleware('optional.auth');

Route::prefix('constants')->group(function () {
    Route::get('ad-types', GetAdTypeHandler::class);
    Route::get('estate-types', GetEstateTypeHandler::class);
    Route::get('property-utilities', GetPropertyUtilityHandler::class);
    Route::get('reasons', GetReasonHandler::class);
    Route::get('usage-types', GetUsageTypeHandler::class);
    Route::group([
        'prefix' => 'geography',
    ],function () {
        Route::get('regions', GetRegionHandler::class);
        Route::get('region-maps', GetRegionMapHandler::class);
        Route::get('cities', GetCityHandler::class);
        Route::get('neighborhoods', GetNeighborhoodHandler::class);
    });
});


