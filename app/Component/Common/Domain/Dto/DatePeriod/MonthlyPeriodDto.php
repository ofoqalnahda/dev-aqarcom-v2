<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Dto\DatePeriod;

use App\Component\Subscription\Domain\Enum\SubscriptionPeriodEnum;
use Carbon\Carbon;

class MonthlyPeriodDto extends PeriodDto
{
    public function __construct(Carbon $startDate, public readonly int $months)
    {
        parent::__construct(
            startDate: $startDate,
            endDate: $startDate->copy()->addDays($this->inDays())
        );
    }

    public function inDays(): int
    {
        return SubscriptionPeriodEnum::numberOfDaysInMonths($this->months);
    }

    public function asSubscriptionPeriod(): SubscriptionPeriodEnum
    {
        return SubscriptionPeriodEnum::from($this->months);
    }
}
