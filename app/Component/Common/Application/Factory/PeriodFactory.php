<?php

declare(strict_types = 1);

namespace App\Component\Common\Application\Factory;

use App\Component\Common\Domain\Dto\DatePeriod\DailyPeriodDto;
use App\Component\Common\Domain\Dto\DatePeriod\MonthlyPeriodDto;
use Carbon\Carbon;

interface PeriodFactory
{
    public function createDailyPeriodForCarRental(Carbon $startDateTime, Carbon $endDate): DailyPeriodDto;

    public function createMonthlyPeriodForCarRental(Carbon $startDateTime, int $months): MonthlyPeriodDto;
}
