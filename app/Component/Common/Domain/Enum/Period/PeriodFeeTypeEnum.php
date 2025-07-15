<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Enum\Period;

enum PeriodFeeTypeEnum: string
{
    case PER_PERIOD = 'per_period';
    case PER_PERIOD_UNIT = 'per_period_unit';
}
