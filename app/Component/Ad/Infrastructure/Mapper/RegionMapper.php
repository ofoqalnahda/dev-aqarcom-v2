<?php

namespace App\Component\Ad\Infrastructure\Mapper;

use App\Component\Ad\Application\Mapper\RegionMapperInterface;
use App\Component\Ad\Presentation\ViewModel\RegionViewModel;

class RegionMapper implements RegionMapperInterface
{
    public function toViewModel($Region): RegionViewModel
    {
        return new RegionViewModel($Region);
    }
    public function toViewModelCollection(array $Region): array
    {
        return array_map(function ($Region) {
            return $this->toViewModel($Region);
        }, $Region);
    }
}
