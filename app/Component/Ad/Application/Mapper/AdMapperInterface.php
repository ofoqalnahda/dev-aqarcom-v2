<?php

namespace App\Component\Ad\Application\Mapper;

use App\Component\Ad\Presentation\ViewModel\AdExistsAdViewModel;
use App\Component\Ad\Presentation\ViewModel\AdPlatformViewModel;
use App\Component\Ad\Presentation\ViewModel\AdViewModel;

interface AdMapperInterface
{
    /**
     * Map an Ad model to a AdViewModel.
     * @param mixed $ad
     * @return AdViewModel
     */
    public function toViewModel($ad): AdViewModel;
    public function toExistsViewModel($ad): AdExistsAdViewModel;
    public function toPlatformViewModel($ad): AdPlatformViewModel;
}
