<?php

use App\Component\Ad\Infrastructure\Http\Handler\CheckAdLicenseHandler;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'ads',

],function (){
    Route::post('check-license', CheckAdLicenseHandler::class)->middleware('auth:sanctum');

});
