<?php

declare(strict_types=1);

namespace App\Component\Money\Domain\Dto;

use Money\Money;

class PriceDto
{
    public function __construct(
        public readonly Money $nett,
        public readonly Money $gross,
        public readonly int   $rate,
    )
    {
    }

    public function absolute(): Money
    {
        return $this->gross->absolute();
    }

    public function currencySymbol(): string
    {
        return $this->gross->getCurrency()->getCode();
    }

    public static function createEmpty(): self
    {
        return new self(
            nett : Money::SAR(0),
            gross: Money::SAR(0),
            rate : 0,
        );
    }
}
