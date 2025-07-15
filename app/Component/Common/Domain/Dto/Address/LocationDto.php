<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Dto\Address;

class LocationDto
{
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly string $address,
    )
    {
    }
}
