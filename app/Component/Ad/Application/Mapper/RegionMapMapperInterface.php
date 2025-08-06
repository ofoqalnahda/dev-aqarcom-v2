<?php

namespace App\Component\Ad\Application\Mapper;

use App\Component\Ad\Presentation\ViewModel\RegionMapViewModel;

interface RegionMapMapperInterface
{
    /**
     * Map  Type Ad View Model to a AdViewModel.
     * @param  $RegionMap
     * @return RegionMapViewModel
     */
    public function toViewModel($RegionMap):RegionMapViewModel;
}
