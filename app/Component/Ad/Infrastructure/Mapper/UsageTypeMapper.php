<?php

namespace App\Component\Ad\Infrastructure\Mapper;

use App\Component\Ad\Application\Mapper\AdMapperInterface;
use App\Component\Ad\Application\Mapper\UsageTypeMapperInterface;
use App\Component\Ad\Presentation\ViewModel\AdExistsAdViewModel;
use App\Component\Ad\Presentation\ViewModel\AdViewListModel;
use App\Component\Ad\Presentation\ViewModel\AdPlatformViewModel;
use App\Component\Ad\Presentation\ViewModel\AdViewModel;
use App\Component\Ad\Presentation\ViewModel\UsageTypeViewModel;

class UsageTypeMapper implements UsageTypeMapperInterface
{
    public function toViewModel($UsageType): UsageTypeViewModel
    {
        return new UsageTypeViewModel($UsageType);
    }
    public function toViewModelCollection(array $UsageType): array
    {
        return array_map(function ($UsageType) {
            return $this->toViewModel($UsageType);
        }, $UsageType);
    }
}
