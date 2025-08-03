<?php

namespace App\Component\Ad\Infrastructure\ServiceProvider;


use App\Component\Ad\Application\Mapper\AdMapperInterface;
use App\Component\Ad\Application\Mapper\EstateTypeMapperInterface;
use App\Component\Ad\Application\Mapper\PropertyUtilityMapperInterface;
use App\Component\Ad\Application\Mapper\AdTypeMapperInterface;
use App\Component\Ad\Application\Mapper\UsageTypeMapperInterface;
use App\Component\Ad\Application\Repository\AdRepository;
use App\Component\Ad\Application\Repository\EstateTypeRepository;
use App\Component\Ad\Application\Repository\PropertyUtilityRepository;
use App\Component\Ad\Application\Repository\AdTypeRepository;
use App\Component\Ad\Application\Repository\UsageTypeRepository;
use App\Component\Ad\Application\Service\AdServiceInterface;
use App\Component\Ad\Application\Service\AdTypeServiceInterface;
use App\Component\Ad\Application\Service\EstateTypeServiceInterface;
use App\Component\Ad\Application\Service\PropertyUtilityServiceInterface;

use App\Component\Ad\Application\Service\UsageTypeServiceInterface;
use App\Component\Ad\Infrastructure\Mapper\AdMapper;
use App\Component\Ad\Infrastructure\Mapper\AdTypeMapper;
use App\Component\Ad\Infrastructure\Mapper\EstateTypeMapper;
use App\Component\Ad\Infrastructure\Mapper\PropertyUtilityMapper;
use App\Component\Ad\Infrastructure\Mapper\UsageTypeMapper;
use App\Component\Ad\Infrastructure\Repository\AdRepositoryEloquent;
use App\Component\Ad\Infrastructure\Repository\AdTypeRepositoryEloquent;
use App\Component\Ad\Infrastructure\Repository\EstateTypeRepositoryEloquent;
use App\Component\Ad\Infrastructure\Repository\PropertyUtilityRepositoryEloquent;
use App\Component\Ad\Infrastructure\Repository\UsageTypeRepositoryEloquent;
use App\Component\Ad\Infrastructure\Service\AdService;
use App\Component\Ad\Infrastructure\Service\EstateTypeService;
use App\Component\Ad\Infrastructure\Service\AdTypeService;
use App\Component\Ad\Infrastructure\Service\PropertyUtilityService;
use App\Component\Ad\Infrastructure\Service\UsageTypeService;
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

            /** Type Ad bindings **/
            AdTypeRepository::class =>AdTypeRepositoryEloquent::class,
            AdTypeServiceInterface::class =>  AdTypeService::class,
            AdTypeMapperInterface::class =>  AdTypeMapper::class,



            /** Estate Type bindings **/
            EstateTypeRepository::class =>EstateTypeRepositoryEloquent::class,
            EstateTypeServiceInterface::class =>  EstateTypeService::class,
            EstateTypeMapperInterface::class =>  EstateTypeMapper::class,

            /** Property Utility bindings **/
            PropertyUtilityRepository::class =>PropertyUtilityRepositoryEloquent::class,
            PropertyUtilityServiceInterface::class =>  PropertyUtilityService::class,
            PropertyUtilityMapperInterface::class =>  PropertyUtilityMapper::class,
            /** Usage Type bindings **/
            UsageTypeRepository::class =>UsageTypeRepositoryEloquent::class,
            UsageTypeServiceInterface::class =>  UsageTypeService::class,
            UsageTypeMapperInterface::class =>  UsageTypeMapper::class,

        ];
    }

}
