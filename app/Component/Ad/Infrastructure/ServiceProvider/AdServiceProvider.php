<?php

namespace App\Component\Ad\Infrastructure\ServiceProvider;


use App\Component\Ad\Application\Mapper\AdMapperInterface;
use App\Component\Ad\Application\Repository\AdRepository;
use App\Component\Ad\Application\Service\AdServiceInterface;
use App\Component\Ad\Infrastructure\Mapper\AdMapper;
use App\Component\Ad\Infrastructure\Repository\AdRepositoryEloquent;
use App\Component\Ad\Infrastructure\Service\AdService;
use App\Component\Ad\Infrastructure\ViewQuery\AdViewQuery;
use App\Component\Ad\Presentation\ViewQuery\AdViewQueryInterface;
use App\Component\Common\Infrastructure\ServiceProvider\ServiceProvider;

class AdServiceProvider extends ServiceProvider
{


    public function boot(): void
    {

    }

    protected function regularBindings(): array
    {
        return [
            AdViewQueryInterface::class => AdViewQuery::class,
            AdRepository::class => AdRepositoryEloquent::class,
            AdServiceInterface::class => AdService::class,
            AdMapperInterface::class => AdMapper::class,
        ];
    }

}
