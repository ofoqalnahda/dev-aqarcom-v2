<?php

declare(strict_types = 1);

namespace App\Component\Money\Infrastructure\Formatter;

use App\Component\Money\Application\Formatter\MoneyFormatter;
use Money\Money;
use Money\MoneyFormatter as Formatter;

class MoneyApplicationFormatter implements MoneyFormatter
{
    public function __construct(
        private readonly Formatter $moneyFormatter,
        private readonly Formatter $decimalFormatter,
    ) {
    }

    public function asMoney(Money $money): string
    {
        return $this->moneyFormatter->format($money);
    }

    public function asDecimal(Money $money): float
    {
        return (float) $this->asDecimalString($money);
    }

    public function asDecimalString(Money $money): string
    {
        return $this->decimalFormatter->format($money);
    }
}
