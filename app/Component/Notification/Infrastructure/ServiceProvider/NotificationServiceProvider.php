<?php

namespace App\Component\Notification\Infrastructure\ServiceProvider;

use App\Component\Notification\Application\Mapper\NotificationMapperInterface;
use App\Component\Notification\Application\Repository\NotificationRepositoryInterface;
use App\Component\Notification\Application\Service\NotificationServiceInterface;
use App\Component\Notification\Infrastructure\Repository\NotificationRepositoryEloquent;
use App\Component\Notification\Infrastructure\Service\NotificationService;
use App\Component\Notification\Presentation\ViewQuery\NotificationViewQueryInterface;
use App\Component\Notification\Infrastructure\Mapper\NotificationMapper;
use App\Component\Notification\Presentation\ViewQuery\NotificationViewQuery;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepositoryEloquent::class);
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);
        $this->app->bind(NotificationMapperInterface::class, NotificationMapper::class);
        $this->app->bind(NotificationViewQueryInterface::class, NotificationViewQuery::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
