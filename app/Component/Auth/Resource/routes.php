<?php

use App\Component\Auth\Infrastructure\Http\Handler\CompleteProfileHandler;
use App\Component\Auth\Infrastructure\Http\Handler\EditProfileHandler;
use App\Component\Auth\Infrastructure\Http\Handler\LoginHandler;
use App\Component\Auth\Infrastructure\Http\Handler\RegisterHandler;
use App\Component\Auth\Infrastructure\Http\Handler\VerifyCodeHandler;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
],function (){
    Route::post('login', LoginHandler::class);
    Route::post('verify-code', VerifyCodeHandler::class);
//    Route::post('register', RegisterHandler::class);
    Route::post('complete-profile', CompleteProfileHandler::class)->middleware('auth:sanctum');
    Route::post('edit-profile', EditProfileHandler::class)->middleware('auth:sanctum');
});
