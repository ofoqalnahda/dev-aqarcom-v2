<?php

declare(strict_types = 1);

namespace App\Component\Money\Application\Calculator;

use App\Component\Money\Domain\Enum\CurrencyEnum;
use Illuminate\Support\Collection;
use Money\Money;

interface MoneyCalculator
{
    public function calculateNett(
        Money $amount,
        int $taxRate,
    ): Money;

    public function calculateGross(
        Money $amount,
        int $taxRate,
    ): Money;

    public function calculateAmountPercentageWithCap(
        Money $amount,
        int|float $percentage,
        ?Money $cap = null,
    ): Money;

    public function calculateAmountWithCap(Money $amount, Money $cap): Money;

    public function sum(
        Collection $items,
        ?callable $callback = null,
        CurrencyEnum $currency = CurrencyEnum::SAR
    ): Money;
}
