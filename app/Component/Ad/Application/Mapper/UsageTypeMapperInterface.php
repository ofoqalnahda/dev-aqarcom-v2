<?php

namespace App\Component\Ad\Application\Mapper;

use App\Component\Ad\Presentation\ViewModel\UsageTypeViewModel;

interface UsageTypeMapperInterface
{
    /**
     * Map  Type Ad View Model to a AdViewModel.
     * @param  $UsageType
     * @return UsageTypeViewModel
     */
    public function toViewModel($UsageType):UsageTypeViewModel;
}
