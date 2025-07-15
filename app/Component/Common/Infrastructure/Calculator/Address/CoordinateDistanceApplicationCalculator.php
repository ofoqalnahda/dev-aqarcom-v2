<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Calculator\Address;

use App\Component\Common\Application\Calculator\Address\CoordinateDistanceCalculator;
use App\Component\Common\Domain\Dto\Address\CoordinateDto;

class CoordinateDistanceApplicationCalculator implements CoordinateDistanceCalculator
{
    private const EARTH_RADIUS = 6371000;
    private const METERS_IN_KILOMETER = 1000;

    public function inMeters(
        CoordinateDto $from,
        CoordinateDto $to,
    ): int
    {
        $latitudeFrom = deg2rad($from->latitude);
        $latitudeTo = deg2rad($to->latitude);
        $latitudeDelta = $latitudeTo - $latitudeFrom;
        $longitudeDelta = deg2rad($to->longitude) - deg2rad($from->longitude);
        $angle = 2 * asin(sqrt(
            sin($latitudeDelta / 2) ** 2 +
            cos($latitudeFrom) *
            cos($latitudeTo) *
            sin($longitudeDelta / 2) ** 2,
        ));

        return (int) ($angle * self::EARTH_RADIUS);
    }

    public function inKilometers(
        CoordinateDto $from,
        CoordinateDto $to,
        int $precision = 2,
    ): float
    {
        return round(
            $this->inMeters($from, $to) / self::METERS_IN_KILOMETER,
            $precision,
        );
    }
}
