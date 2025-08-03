<?php

namespace App\Component\Ad\Application\Mapper;

use App\Component\Ad\Presentation\ViewModel\EstateTypeViewModel;

interface EstateTypeMapperInterface
{
    /**
     * Map  Type Ad View Model to a AdViewModel.
     * @param  $EstateType
     * @return EstateTypeViewModel
     */
    public function toViewModel($EstateType):EstateTypeViewModel;
}
