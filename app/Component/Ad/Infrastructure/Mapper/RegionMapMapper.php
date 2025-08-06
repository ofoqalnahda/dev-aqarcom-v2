<?php

namespace App\Component\Ad\Infrastructure\Mapper;

use App\Component\Ad\Application\Mapper\RegionMapMapperInterface;
use App\Component\Ad\Presentation\ViewModel\RegionMapViewModel;

class RegionMapMapper implements RegionMapMapperInterface
{
    public function toViewModel($RegionMap): RegionMapViewModel
    {
        return new RegionMapViewModel($RegionMap);
    }
    public function toViewModelCollection(array $RegionMap): array
    {
        return array_map(function ($RegionMap) {
            return $this->toViewModel($RegionMap);
        }, $RegionMap);
    }
}
