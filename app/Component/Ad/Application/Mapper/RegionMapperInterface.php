<?php

namespace App\Component\Ad\Application\Mapper;

use App\Component\Ad\Presentation\ViewModel\RegionViewModel;

interface RegionMapperInterface
{
    /**
     * Map  Type Ad View Model to a AdViewModel.
     * @param  $Region
     * @return RegionViewModel
     */
    public function toViewModel($Region):RegionViewModel;
}
