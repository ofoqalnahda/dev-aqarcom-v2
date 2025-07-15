<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Dto\Address;

class CoordinateDto
{
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
    )
    {
    }
}
