<?php

use App\Component\Notification\Infrastructure\Http\Handler\ListNotificationsHandler;
use App\Component\Notification\Infrastructure\Http\Handler\MarkAsReadHandler;
use App\Component\Notification\Infrastructure\Http\Handler\MarkAllAsReadHandler;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'notifications',
    'middleware' => 'auth:sanctum'
], function () {
    Route::get('/', ListNotificationsHandler::class);
    Route::post('mark-all-as-read', MarkAllAsReadHandler::class);
    Route::post('{id}/mark-as-read', MarkAsReadHandler::class);
});
