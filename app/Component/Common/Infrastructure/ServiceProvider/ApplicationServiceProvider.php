<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\ServiceProvider;

use App\Component\Common\Application\Mapper\PaginatedListViewModelMapper;
use App\Component\Common\Application\Calculator\Address\CoordinateDistanceCalculator;
use App\Component\Common\Application\Factory\PeriodFactory;
use App\Component\Common\Application\Service\Csv\CsvService;
use App\Component\Common\Application\Service\Notification\NotificationService;
use App\Component\Common\Infrastructure\Calculator\Address\CoordinateDistanceApplicationCalculator;
use App\Component\Common\Infrastructure\Factory\DatePeriod\PeriodApplicationFactory;
use App\Component\Common\Infrastructure\Log\Application\ApplicationLogManager;
use App\Component\Common\Infrastructure\Mapper\Pagination\PaginatedListViewModelApplicationMapper;
use App\Component\Common\Infrastructure\Service\Csv\CsvApplicationService;
use App\Component\Common\Infrastructure\Service\Notification\NotificationApplicationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class ApplicationServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public function register(): void
    {
        $this->app->singleton(CoordinateDistanceCalculator::class, CoordinateDistanceApplicationCalculator::class);
        $this->app->singleton(PeriodFactory::class, PeriodApplicationFactory::class);
        $this->registerLogger();
        $this->registerTranslation();
        $this->registerSystemClient();
        $this->app->bind(CsvService::class, CsvApplicationService::class);
        $this->app->bind(LengthAwarePaginator::class);
        $this->app->bind(PaginatedListViewModelMapper::class, PaginatedListViewModelApplicationMapper::class);
        $this->app->bind(NotificationService::class, NotificationApplicationService::class);
    }

    public function provides(): array
    {
        return [
            'log',
            LoggerInterface::class,
            CsvService::class,
            CoordinateDistanceCalculator::class,
            LengthAwarePaginator::class,
            PeriodFactory::class,
            PaginatedListViewModelMapper::class,
            NotificationService::class,
        ];
    }

    private function registerLogger(): void
    {
        $this->app->singleton('log', static fn (Application $app) => new ApplicationLogManager($app));
    }

    private function registerSystemClient(): void
    {
    }

    private function registerTranslation(): void
    {
    }
}
