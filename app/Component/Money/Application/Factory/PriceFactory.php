<?php

declare(strict_types = 1);

namespace App\Component\Money\Application\Factory;

use App\Component\Money\Domain\Dto\PriceDto;
use App\Component\Money\Domain\Enum\CurrencyEnum;
use Money\Money;

interface PriceFactory
{
    public function createPriceFromNett(Money $nett, ?CurrencyEnum $currency = null): PriceDto;

    public function createPriceFromGross(Money $gross, ?CurrencyEnum $currency = null): PriceDto;
}
