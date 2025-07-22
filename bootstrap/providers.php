<?php

use App\Component\Ad\Infrastructure\ServiceProvider\AdServiceProvider;
use App\Component\Auth\Infrastructure\ServiceProvider\AuthServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    App\Component\Common\Infrastructure\ServiceProvider\ApplicationServiceProvider::class,
    AuthServiceProvider::class,
    AdServiceProvider::class,

];
