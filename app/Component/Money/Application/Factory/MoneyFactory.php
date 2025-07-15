<?php

declare(strict_types = 1);

namespace App\Component\Money\Application\Factory;

use App\Component\Money\Domain\Enum\CurrencyEnum;
use Money\Money;

interface MoneyFactory
{
    public function byInteger(
        int $amount,
        CurrencyEnum $currency,
    ): Money;

    public function byDecimal(
        string $amount,
        CurrencyEnum $currency,
    ): Money;

    public function empty(CurrencyEnum $currency): Money;
}
