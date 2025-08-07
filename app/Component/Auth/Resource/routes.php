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
    Route::post('verify-code', \App\Component\Auth\Infrastructure\Http\Handler\VerifyCodeHandler::class);
    Route::post('resend-code', \App\Component\Auth\Infrastructure\Http\Handler\ResendCodeHandler::class);
//    Route::post('register', RegisterHandler::class);
});

Route::group([
    'prefix' => 'auth',
    'middleware' => 'auth:sanctum',
], function () {
    Route::post('logout', \App\Component\Auth\Infrastructure\Http\Handler\LogoutHandler::class);
    Route::post('complete-profile', \App\Component\Auth\Infrastructure\Http\Handler\CompleteProfileHandler::class);
    Route::post('edit-profile', \App\Component\Auth\Infrastructure\Http\Handler\EditProfileHandler::class);


});
