<?php

namespace App\Component\Ad\Infrastructure\Mapper;

use App\Component\Ad\Application\Mapper\ReasonMapperInterface;
use App\Component\Ad\Presentation\ViewModel\ReasonViewModel;

class ReasonMapper implements ReasonMapperInterface
{
    public function toViewModel($Reason): ReasonViewModel
    {
        return new ReasonViewModel($Reason);
    }
    public function toViewModelCollection(array $Reason): array
    {
        return array_map(function ($Reason) {
            return $this->toViewModel($Reason);
        }, $Reason);
    }
}
