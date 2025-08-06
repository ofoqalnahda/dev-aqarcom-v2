<?php

namespace App\Component\Ad\Infrastructure\Mapper;

use App\Component\Ad\Application\Mapper\CityMapperInterface;
use App\Component\Ad\Presentation\ViewModel\CityViewModel;

class CityMapper implements CityMapperInterface
{
    public function toViewModel($City): CityViewModel
    {
        return new CityViewModel($City);
    }
    public function toViewModelCollection(array $City): array
    {
        return array_map(function ($City) {
            return $this->toViewModel($City);
        }, $City);
    }
}
