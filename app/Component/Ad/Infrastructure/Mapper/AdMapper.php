<?php

namespace App\Component\Ad\Infrastructure\Mapper;

use App\Component\Ad\Application\Mapper\AdMapperInterface;
use App\Component\Ad\Presentation\ViewModel\AdExistsAdViewModel;
use App\Component\Ad\Presentation\ViewModel\AdViewListModel;
use App\Component\Ad\Presentation\ViewModel\AdPlatformViewModel;
use App\Component\Ad\Presentation\ViewModel\AdViewModel;

class AdMapper implements AdMapperInterface
{
    public function toViewModel(mixed $ad): AdViewModel
    {
        return new AdViewModel($ad);
    }
    public function toExistsViewModel($ad): AdExistsAdViewModel
    {
        return new AdExistsAdViewModel($ad);
    }

    public function toPlatformViewModel($ad): AdPlatformViewModel
    {
        return new AdPlatformViewModel($ad);
    }

    public function toViewLiseModel($ad): AdViewListModel
    {
        return new AdViewListModel($ad);

    }
    public function toViewLiseModelCollection(array $ad): array
    {
        return array_map(function ($ad) {
            return $this->toViewLiseModel($ad);
        }, $ad);
    }
}
