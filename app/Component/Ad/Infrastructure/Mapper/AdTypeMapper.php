<?php

namespace App\Component\Ad\Infrastructure\Mapper;

use App\Component\Ad\Application\Mapper\AdTypeMapperInterface;
use App\Component\Ad\Presentation\ViewModel\AdTypeViewModel;
use App\Component\Ad\Presentation\ViewModel\UsageTypeViewModel;

class AdTypeMapper implements AdTypeMapperInterface
{
    public function toViewModel($AdType): AdTypeViewModel
    {
        return new AdTypeViewModel($AdType);
    }
    public function toViewModelCollection(array $AdType): array
    {
        return array_map(function ($AdType) {
            return $this->toViewModel($AdType);
        }, $AdType);
    }
}
