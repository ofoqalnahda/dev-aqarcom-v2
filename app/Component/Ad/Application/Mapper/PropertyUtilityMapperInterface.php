<?php

namespace App\Component\Ad\Application\Mapper;

use App\Component\Ad\Presentation\ViewModel\PropertyUtilityViewModel;

interface PropertyUtilityMapperInterface
{
    /**
     * Map  Type Ad View Model to a AdViewModel.
     * @param  $PropertyUtility
     * @return PropertyUtilityViewModel
     */
    public function toViewModel($PropertyUtility):PropertyUtilityViewModel;
}
