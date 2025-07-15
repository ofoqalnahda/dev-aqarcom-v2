<?php

declare(strict_types = 1);

namespace App\Component\Common\Application\Calculator\Address;

use App\Component\Common\Domain\Dto\Address\CoordinateDto;

interface CoordinateDistanceCalculator
{
    public function inMeters(
        CoordinateDto $from,
        CoordinateDto $to,
    ): int;

    public function inKilometers(
        CoordinateDto $from,
        CoordinateDto $to,
        int $precision = 2,
    ): float;
}
