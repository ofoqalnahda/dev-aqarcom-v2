<?php

use App\Component\Ad\Infrastructure\ServiceProvider\AdServiceProvider;
use App\Component\Auth\Infrastructure\ServiceProvider\AuthServiceProvider;
use App\Component\Settings\Infrastructure\ServiceProvider\SettingsServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    App\Component\Common\Infrastructure\ServiceProvider\ApplicationServiceProvider::class,
    AuthServiceProvider::class,
    SettingsServiceProvider::class,
    AdServiceProvider::class,

];
