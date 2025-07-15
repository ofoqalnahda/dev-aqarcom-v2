<?php

declare(strict_types = 1);

namespace App\Component\Money\Infrastructure\Calculator;

use App\Component\Money\Application\Calculator\MoneyCalculator;
use App\Component\Money\Application\Factory\MoneyFactory;
use App\Component\Money\Domain\Enum\CurrencyEnum;
use Illuminate\Support\Collection;
use Money\Money;

class MoneyApplicationCalculator implements MoneyCalculator
{
    public function __construct(private readonly MoneyFactory $moneyFactory)
    {
    }

    public function calculateNett(Money $amount, int $taxRate): Money
    {
        return $amount->multiply(100)->divide(100 + $taxRate);
    }

    public function calculateGross(Money $amount, int $taxRate): Money
    {
        return $amount->multiply(100 + $taxRate)->divide(100);
    }

    public function calculateAmountPercentageWithCap(Money $amount, int|float $percentage, ?Money $cap = null): Money
    {
        $percentageAmount = $amount->multiply($percentage)->divide(100);

        if ($cap !== null && $cap->isPositive()) {
            return $this->calculateAmountWithCap($percentageAmount, $cap);
        }

        return $percentageAmount;
    }

    public function sum(
        Collection $items,
        ?callable $callback = null,
        CurrencyEnum $currency = CurrencyEnum::SAR
    ): Money
    {
        $callback ??= static fn (Money $money) => $money;

        return $items->reduce(
            callback: fn (Money $total, mixed $item) => $total->add($callback($item)),
            initial: $this->moneyFactory->empty($currency)
        );
    }

    public function calculateAmountWithCap(Money $amount, Money $cap): Money
    {
        return $amount->greaterThanOrEqual($cap) ? $cap : $amount;
    }
}
