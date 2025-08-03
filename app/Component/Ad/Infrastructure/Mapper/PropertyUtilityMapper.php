<?php

namespace App\Component\Ad\Infrastructure\Mapper;

use App\Component\Ad\Application\Mapper\PropertyUtilityMapperInterface;
use App\Component\Ad\Presentation\ViewModel\PropertyUtilityViewModel;
use App\Component\Ad\Presentation\ViewModel\UsageTypeViewModel;

class PropertyUtilityMapper implements PropertyUtilityMapperInterface
{
    public function toViewModel($PropertyUtility): PropertyUtilityViewModel
    {
        return new PropertyUtilityViewModel($PropertyUtility);
    }
    public function toViewModelCollection(array $PropertyUtility): array
    {
        return array_map(function ($PropertyUtility) {
            return $this->toViewModel($PropertyUtility);
        }, $PropertyUtility);
    }
}
