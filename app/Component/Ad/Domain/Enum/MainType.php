<?php

namespace App\Component\Ad\Domain\Enum;

use App\Component\Common\Domain\Enum\Application\StandardEnum;

enum MainType: string
{
    use StandardEnum;

    CASE SELL = 'sell';
    case Buy = 'buy';
}
