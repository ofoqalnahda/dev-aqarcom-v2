<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Factory\DatePeriod;

//use App\Component\Common\Application\Factory\PeriodFactory;
use App\Component\Common\Domain\Dto\DatePeriod\DailyPeriodDto;
use App\Component\Common\Domain\Dto\DatePeriod\MonthlyPeriodDto;
use Carbon\Carbon;

class PeriodApplicationFactory // implements PeriodFactory
{
    public function createDailyPeriodForCarRental(
        Carbon $startDateTime,
        Carbon $endDate,
    ): DailyPeriodDto
    {
        return new DailyPeriodDto(
            startDate: $startDateTime,
            endDate: $endDate->endOfDay(),
        );
    }

    public function createMonthlyPeriodForCarRental(Carbon $startDateTime, int $months): MonthlyPeriodDto
    {
        return new MonthlyPeriodDto(
            startDate: $startDateTime,
            months: $months,
        );
    }
}
