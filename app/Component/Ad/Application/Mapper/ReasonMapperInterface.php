<?php

namespace App\Component\Ad\Application\Mapper;

use App\Component\Ad\Presentation\ViewModel\ReasonViewModel;

interface ReasonMapperInterface
{
    /**
     * Map  Type Ad View Model to a AdViewModel.
     * @param  $Reason
     * @return ReasonViewModel
     */
    public function toViewModel($Reason):ReasonViewModel;
}
