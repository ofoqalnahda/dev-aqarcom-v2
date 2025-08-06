<?php

namespace App\Component\Ad\Application\Mapper;

use App\Component\Ad\Presentation\ViewModel\CityViewModel;

interface CityMapperInterface
{
    /**
     * Map  Type Ad View Model to a AdViewModel.
     * @param  $City
     * @return CityViewModel
     */
    public function toViewModel($City):CityViewModel;
}
