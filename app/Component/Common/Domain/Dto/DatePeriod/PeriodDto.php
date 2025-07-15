<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Dto\DatePeriod;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PeriodDto
{
    public function __construct(
        public readonly Carbon $startDate,
        public readonly Carbon $endDate,
    )
    {
    }

    public function diffInDaysUsingHours(): int
    {
        return (int)ceil( $this->startDate->diffInHours($this->endDate) / 24 );
    }

    public function start(): Carbon
    {
        return $this->startDate->copy();
    }

    public function end(): Carbon
    {
        return $this->endDate->copy();
    }

    public function inDays(): int
    {
        return $this->startDate->diffInDays($this->endDate);
    }

    public static function fake(
        string $from = 'now',
        string $until = '+3days',
    ): static
    {
        return new static(
            startDate: Carbon::parse($from),
            endDate: Carbon::parse($until),
        );
    }
}
