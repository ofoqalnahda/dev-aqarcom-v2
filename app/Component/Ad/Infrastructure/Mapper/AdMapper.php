<?php

namespace App\Component\Ad\Infrastructure\Mapper;

use App\Component\Ad\Application\Mapper\AdMapperInterface;
use App\Component\Ad\Presentation\ViewModel\AdBuyViewListModel;
use App\Component\Ad\Presentation\ViewModel\AdBuyViewModel;
use App\Component\Ad\Presentation\ViewModel\AdExistsAdViewModel;
use App\Component\Ad\Presentation\ViewModel\AdStoryViewListModel;
use App\Component\Ad\Presentation\ViewModel\AdViewListModel;
use App\Component\Ad\Presentation\ViewModel\AdPlatformViewModel;
use App\Component\Ad\Presentation\ViewModel\AdViewModel;
use App\Component\Ad\Presentation\ViewModel\UserStoryViewListModel;

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

    public function toViewListModel($ad): AdViewListModel
    {
        return new AdViewListModel($ad);

    }
    public function toViewLiseModelCollection($ad): array
    {
        return array_map(function ($ad) {
            return $this->toViewListModel($ad);
        }, $ad);
    }

    public function toBuyViewListModel($ad): AdBuyViewListModel
    {
        return new AdBuyViewListModel($ad);

    }

    public function toViewBuyLiseModelCollection($ad): array
    {
        return array_map(function ($ad) {
            return $this->toBuyViewListModel($ad);
        }, $ad);
    }



    public function toStoryViewListModel($ad): AdStoryViewListModel
    {
        return new AdStoryViewListModel($ad);

    }

    public function toViewStoryLiseModelCollection($ad): array
    {
        return array_map(function ($ad) {
            return $this->toStoryViewListModel($ad);
        }, $ad);
    }


    public function toUserStoryViewListModel($ad): UserStoryViewListModel
    {
        return new UserStoryViewListModel($this, $ad);

    }

    public function toViewUserStoryLiseModelCollection($ad): array
    {

        return array_map(function ($ad) {
            return $this->toUserStoryViewListModel($ad);
        }, $ad);
    }

    public function toBuyViewModel(mixed $ad): AdBuyViewModel
    {
        return new AdBuyViewModel($ad);
    }


}
