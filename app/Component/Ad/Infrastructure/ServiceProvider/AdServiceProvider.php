<?php

namespace App\Component\Ad\Infrastructure\ServiceProvider;


use App\Component\Ad\Application\Mapper\AdMapperInterface;
use App\Component\Ad\Application\Mapper\CityMapperInterface;
use App\Component\Ad\Application\Mapper\EstateTypeMapperInterface;
use App\Component\Ad\Application\Mapper\NeighborhoodMapperInterface;
use App\Component\Ad\Application\Mapper\PropertyUtilityMapperInterface;
use App\Component\Ad\Application\Mapper\AdTypeMapperInterface;
use App\Component\Ad\Application\Mapper\ReasonMapperInterface;
use App\Component\Ad\Application\Mapper\RegionMapMapperInterface;
use App\Component\Ad\Application\Mapper\RegionMapperInterface;
use App\Component\Ad\Application\Mapper\UsageTypeMapperInterface;
use App\Component\Ad\Application\Repository\AdRepository;
use App\Component\Ad\Application\Repository\CityRepository;
use App\Component\Ad\Application\Repository\EstateTypeRepository;
use App\Component\Ad\Application\Repository\NeighborhoodRepository;
use App\Component\Ad\Application\Repository\PropertyUtilityRepository;
use App\Component\Ad\Application\Repository\AdTypeRepository;
use App\Component\Ad\Application\Repository\ReasonRepository;
use App\Component\Ad\Application\Repository\RegionMapRepository;
use App\Component\Ad\Application\Repository\RegionRepository;
use App\Component\Ad\Application\Repository\UsageTypeRepository;
use App\Component\Ad\Application\Service\AdServiceInterface;
use App\Component\Ad\Application\Service\AdTypeServiceInterface;
use App\Component\Ad\Application\Service\CityServiceInterface;
use App\Component\Ad\Application\Service\EstateTypeServiceInterface;
use App\Component\Ad\Application\Service\NeighborhoodServiceInterface;
use App\Component\Ad\Application\Service\PropertyUtilityServiceInterface;

use App\Component\Ad\Application\Service\ReasonServiceInterface;
use App\Component\Ad\Application\Service\RegionMapServiceInterface;
use App\Component\Ad\Application\Service\RegionServiceInterface;
use App\Component\Ad\Application\Service\UsageTypeServiceInterface;
use App\Component\Ad\Infrastructure\Mapper\AdMapper;
use App\Component\Ad\Infrastructure\Mapper\AdTypeMapper;
use App\Component\Ad\Infrastructure\Mapper\CityMapper;
use App\Component\Ad\Infrastructure\Mapper\EstateTypeMapper;
use App\Component\Ad\Infrastructure\Mapper\NeighborhoodMapper;
use App\Component\Ad\Infrastructure\Mapper\PropertyUtilityMapper;
use App\Component\Ad\Infrastructure\Mapper\ReasonMapper;
use App\Component\Ad\Infrastructure\Mapper\RegionMapMapper;
use App\Component\Ad\Infrastructure\Mapper\RegionMapper;
use App\Component\Ad\Infrastructure\Mapper\UsageTypeMapper;
use App\Component\Ad\Infrastructure\Repository\AdRepositoryEloquent;
use App\Component\Ad\Infrastructure\Repository\AdTypeRepositoryEloquent;
use App\Component\Ad\Infrastructure\Repository\CityRepositoryEloquent;
use App\Component\Ad\Infrastructure\Repository\EstateTypeRepositoryEloquent;
use App\Component\Ad\Infrastructure\Repository\NeighborhoodRepositoryEloquent;
use App\Component\Ad\Infrastructure\Repository\PropertyUtilityRepositoryEloquent;
use App\Component\Ad\Infrastructure\Repository\ReasonRepositoryEloquent;
use App\Component\Ad\Infrastructure\Repository\RegionMapRepositoryEloquent;
use App\Component\Ad\Infrastructure\Repository\RegionRepositoryEloquent;
use App\Component\Ad\Infrastructure\Repository\UsageTypeRepositoryEloquent;
use App\Component\Ad\Infrastructure\Service\AdService;
use App\Component\Ad\Infrastructure\Service\CityService;
use App\Component\Ad\Infrastructure\Service\EstateTypeService;
use App\Component\Ad\Infrastructure\Service\AdTypeService;
use App\Component\Ad\Infrastructure\Service\NeighborhoodService;
use App\Component\Ad\Infrastructure\Service\PropertyUtilityService;
use App\Component\Ad\Infrastructure\Service\ReasonService;
use App\Component\Ad\Infrastructure\Service\RegionMapService;
use App\Component\Ad\Infrastructure\Service\RegionService;
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


            /** Reason bindings **/
            ReasonRepository::class =>ReasonRepositoryEloquent::class,
            ReasonServiceInterface::class =>  ReasonService::class,
            ReasonMapperInterface::class =>  ReasonMapper::class,


            /** Region bindings **/
            RegionRepository::class =>RegionRepositoryEloquent::class,
            RegionServiceInterface::class =>  RegionService::class,
            RegionMapperInterface::class =>  RegionMapper::class,

            /** RegionMap bindings **/
            RegionMapRepository::class =>RegionMapRepositoryEloquent::class,
            RegionMapServiceInterface::class =>  RegionMapService::class,
            RegionMapMapperInterface::class =>  RegionMapMapper::class,


            /** City bindings **/
            CityRepository::class =>CityRepositoryEloquent::class,
            CityServiceInterface::class =>  CityService::class,
            CityMapperInterface::class =>  CityMapper::class,

            /** Neighborhood bindings **/
            NeighborhoodRepository::class =>NeighborhoodRepositoryEloquent::class,
            NeighborhoodServiceInterface::class =>  NeighborhoodService::class,
            NeighborhoodMapperInterface::class =>  NeighborhoodMapper::class,

        ];
    }

}
