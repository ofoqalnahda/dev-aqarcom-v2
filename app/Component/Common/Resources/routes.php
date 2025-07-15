<?php

declare(strict_types = 1);

use App\Component\Common\Infrastructure\Http\Handler;
use App\Component\Common\Infrastructure\Http\Handler\Translation\GetOrCreateTranslationHandler;
use App\Component\Content\Infrastructure\Entity\SystemSetting\SystemSettingEntity;
use App\Http\Middleware\CacheControlMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/api/version', Handler\System\GetSystemVersionHandler::class)
    ->middleware(CacheControlMiddleware::longDuration(true));

Route::middleware(['jwt.auth.custom', 'role:admin'])->group(function () {
    Route::put('/api/version', Handler\System\StoreSystemClientsHandler::class);
});

Route::get('/api/translations', GetOrCreateTranslationHandler::class);

Route::any(
    '.well-known/apple-developer-merchantid-domain-association.txt',
    fn () => SystemSettingEntity::query()->where('key', '=', 'apple-developer-merchantid-domain-association')->valueOrFail('data')
);
