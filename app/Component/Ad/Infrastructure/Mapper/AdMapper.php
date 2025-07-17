<?php

namespace App\Component\Ad\Infrastructure\Mapper;

use App\Component\Ad\Application\Mapper\AdMapperInterface;
use App\Component\Ad\Presentation\ViewModel\AdViewModel;

class AdMapper implements AdMapperInterface
{
    public function toViewModel($user): AdViewModel
    {
        return new AdViewModel($user);
    }
}
