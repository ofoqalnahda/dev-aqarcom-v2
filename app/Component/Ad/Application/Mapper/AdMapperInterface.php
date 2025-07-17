<?php

namespace App\Component\Ad\Application\Mapper;

use App\Component\Ad\Presentation\ViewModel\AdViewModel;

interface AdMapperInterface
{
    /**
     * Map a Ad model to a AdViewModel.
     * @param mixed $ad
     * @return AdViewModel
     */
    public function toViewModel($ad): AdViewModel;
}
