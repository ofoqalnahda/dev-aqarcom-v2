<?php

namespace App\Component\Ad\Application\Mapper;

use App\Component\Ad\Presentation\ViewModel\NeighborhoodViewModel;

interface NeighborhoodMapperInterface
{
    /**
     * Map  Type Ad View Model to a AdViewModel.
     * @param  $Neighborhood
     * @return NeighborhoodViewModel
     */
    public function toViewModel($Neighborhood):NeighborhoodViewModel;
}
