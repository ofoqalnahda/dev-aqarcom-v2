<?php

namespace App\Component\Properties\Infrastructure\ServiceProvider;

use Illuminate\Support\ServiceProvider;
use App\Component\Properties\Application\Repository\ServiceRepository;
use App\Component\Properties\Infrastructure\Repository\ServiceRepositoryEloquent;
use App\Component\Properties\Application\Service\ServiceServiceInterface;
use App\Component\Properties\Infrastructure\Service\ServiceService;
use App\Component\Properties\Application\Mapper\ServiceMapperInterface;
use App\Component\Properties\Infrastructure\Mapper\ServiceMapper;
use App\Component\Properties\Presentation\ViewQuery\ServiceViewQueryInterface;
use App\Component\Properties\Infrastructure\ViewQuery\ServiceViewQuery;

class PropertiesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Repository
        $this->app->bind(ServiceRepository::class, ServiceRepositoryEloquent::class);

        // Bind Service
        $this->app->bind(ServiceServiceInterface::class, ServiceService::class);

        // Bind Mapper
        $this->app->bind(ServiceMapperInterface::class, ServiceMapper::class);

        // Bind ViewQuery
        $this->app->bind(ServiceViewQueryInterface::class, ServiceViewQuery::class);
    }

    public function boot(): void
    {
        //
    }
}


