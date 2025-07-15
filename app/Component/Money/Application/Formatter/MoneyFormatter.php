<?php

declare(strict_types = 1);

namespace App\Component\Money\Application\Formatter;

use Money\Money;

interface MoneyFormatter
{
    public function asMoney(Money $money): string;

    public function asDecimal(Money $money): float;

    public function asDecimalString(Money $money): string;
}
