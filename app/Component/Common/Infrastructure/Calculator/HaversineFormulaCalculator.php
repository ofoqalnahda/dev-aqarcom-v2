<?php

declare(strict_types=1);

namespace App\Component\Common\Infrastructure\Calculator;

class HaversineFormulaCalculator
{
    private const EARTH_RADIUS = 6371;

    public function calculateDistance(
        float $latitudeFrom,
        float $longitudeFrom,
        float $latitudeTo,
        float $longitudeTo,
    ): float
    {
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt((sin($latDelta / 2) ** 2) +
                cos($latFrom) * cos($latTo) * (sin($lonDelta / 2) ** 2)));

        return $angle * self::EARTH_RADIUS;
    }
}
