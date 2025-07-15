<?php

declare(strict_types=1);

namespace App\Component\Common\Domain\Enum\Period;

use App\Component\Common\Domain\Enum\Application\StandardEnum;

enum PeriodUnitEnum: string
{
    use StandardEnum;

    case DAY = 'day';
    case MONTH = 'month';
}
