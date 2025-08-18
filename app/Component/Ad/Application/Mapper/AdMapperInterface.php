<?php

namespace App\Component\Ad\Application\Mapper;

use App\Component\Ad\Presentation\ViewModel\AdBuyViewModel;
use App\Component\Ad\Presentation\ViewModel\AdExistsAdViewModel;
use App\Component\Ad\Presentation\ViewModel\AdViewListModel;
use App\Component\Ad\Presentation\ViewModel\AdPlatformViewModel;
use App\Component\Ad\Presentation\ViewModel\AdBuyViewListModel;
use App\Component\Ad\Presentation\ViewModel\AdViewModel;

interface AdMapperInterface
{
    /**
     * Map an Ad model to a AdViewModel.
     * @param  $ad
     * @return AdViewModel
     */
    public function toViewModel($ad): AdViewModel;
    public function toBuyViewModel($ad): AdBuyViewModel;
    public function toViewListModel($ad): AdViewListModel;
    public function toBuyViewListModel($ad): AdBuyViewListModel;
    public function toExistsViewModel($ad): AdExistsAdViewModel;
    public function toPlatformViewModel($ad): AdPlatformViewModel;
}
