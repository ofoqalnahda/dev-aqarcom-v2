<?php

use App\Component\Auth\Infrastructure\Http\Handler\CompleteProfileHandler;
use App\Component\Auth\Infrastructure\Http\Handler\CreateRatingHandler;
use App\Component\Auth\Infrastructure\Http\Handler\DeleteRatingHandler;
use App\Component\Auth\Infrastructure\Http\Handler\EditProfileHandler;
use App\Component\Auth\Infrastructure\Http\Handler\GetCompanyRatingsHandler;
use App\Component\Auth\Infrastructure\Http\Handler\GetServiceProviderHandler;
use App\Component\Auth\Infrastructure\Http\Handler\ListServiceProvidersHandler;
use App\Component\Auth\Infrastructure\Http\Handler\LoginHandler;
use App\Component\Auth\Infrastructure\Http\Handler\LogoutHandler;
use App\Component\Auth\Infrastructure\Http\Handler\RegisterHandler;
use App\Component\Auth\Infrastructure\Http\Handler\ResendCodeHandler;
use App\Component\Auth\Infrastructure\Http\Handler\UpdateRatingHandler;
use App\Component\Auth\Infrastructure\Http\Handler\VerifyCodeHandler;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
],function (){
    Route::post('login', LoginHandler::class);
    Route::post('verify-code', VerifyCodeHandler::class);
    Route::post('resend-code', ResendCodeHandler::class);
//    Route::post('register', RegisterHandler::class);
});

Route::group([
    'prefix' => 'auth',
    'middleware' => 'auth:sanctum',
], function () {
    Route::post('logout', LogoutHandler::class);
    Route::post('complete-profile', CompleteProfileHandler::class);
    Route::post('edit-profile', EditProfileHandler::class);

    // Rating routes
    Route::post('ratings', CreateRatingHandler::class);
    Route::put('ratings/{id}', UpdateRatingHandler::class);
    Route::delete('ratings/{id}', DeleteRatingHandler::class);
});

// Public rating routes
Route::get('auth/companies/{companyId}/ratings', GetCompanyRatingsHandler::class);

// Public service provider routes
Route::get('service-providers', ListServiceProvidersHandler::class);
Route::get('service-providers/{id}', GetServiceProviderHandler::class);
