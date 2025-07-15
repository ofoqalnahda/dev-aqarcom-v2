<?php

use App\Component\Auth\Infrastructure\Http\Handler\LoginHandler;
use App\Component\Auth\Infrastructure\Http\Handler\RegisterHandler;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
],function (){
    Route::post('login', LoginHandler::class);
//    Route::post('register', RegisterHandler::class);
});
