<?php

declare(strict_types = 1);

namespace App\Component\Money\Infrastructure\Factory;

use App\Component\Money\Application\Factory\MoneyFactory;
use App\Component\Money\Domain\Enum\CurrencyEnum;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

class MoneyApplicationFactory implements MoneyFactory
{
    public function __construct(private readonly DecimalMoneyParser $decimalParser)
    {
    }

    public function byInteger(
        int $amount,
        CurrencyEnum $currency,
    ): Money
    {
        return new Money(
            amount  : $amount,
            currency: new Currency($currency->value),
        );
    }

    public function byDecimal(
        string $amount,
        CurrencyEnum $currency,
    ): Money
    {
        return $this->decimalParser->parse(
            money        : $amount,
            forceCurrency: new Currency($currency->value),
        );
    }

    public function empty(CurrencyEnum $currency): Money
    {
        return $this->byInteger(0, $currency);
    }
}
