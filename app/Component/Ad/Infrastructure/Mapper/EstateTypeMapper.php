<?php

namespace App\Component\Ad\Infrastructure\Mapper;

use App\Component\Ad\Application\Mapper\EstateTypeMapperInterface;
use App\Component\Ad\Presentation\ViewModel\EstateTypeViewModel;
use App\Component\Ad\Presentation\ViewModel\UsageTypeViewModel;

class EstateTypeMapper implements EstateTypeMapperInterface
{
    public function toViewModel($EstateType): EstateTypeViewModel
    {
        return new EstateTypeViewModel($EstateType);
    }
    public function toViewModelCollection(array $EstateType): array
    {
        return array_map(function ($EstateType) {
            return $this->toViewModel($EstateType);
        }, $EstateType);
    }
}
