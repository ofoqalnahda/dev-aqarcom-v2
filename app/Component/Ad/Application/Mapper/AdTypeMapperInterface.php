<?php

namespace App\Component\Ad\Application\Mapper;

use App\Component\Ad\Presentation\ViewModel\AdTypeViewModel;

interface AdTypeMapperInterface
{
    /**
     * Map  Type Ad View Model to a AdViewModel.
     * @param  $AdType
     * @return AdTypeViewModel
     */
    public function toViewModel($AdType):AdTypeViewModel;
}
