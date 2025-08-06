<?php

namespace App\Component\Ad\Infrastructure\Mapper;

use App\Component\Ad\Application\Mapper\NeighborhoodMapperInterface;
use App\Component\Ad\Presentation\ViewModel\NeighborhoodViewModel;

class NeighborhoodMapper implements NeighborhoodMapperInterface
{
    public function toViewModel($Neighborhood): NeighborhoodViewModel
    {
        return new NeighborhoodViewModel($Neighborhood);
    }
    public function toViewModelCollection(array $Neighborhood): array
    {
        return array_map(function ($Neighborhood) {
            return $this->toViewModel($Neighborhood);
        }, $Neighborhood);
    }
}
