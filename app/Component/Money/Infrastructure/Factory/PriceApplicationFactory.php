<?php

declare(strict_types = 1);

namespace App\Component\Money\Infrastructure\Factory;

use App\Component\Money\Application\Calculator\MoneyCalculator;
use App\Component\Money\Application\Factory\PriceFactory;
use App\Component\Money\Application\Query\TaxQuery;
use App\Component\Money\Domain\Dto\PriceDto;
use App\Component\Money\Domain\Enum\CurrencyEnum;
use Money\Money;

class PriceApplicationFactory implements PriceFactory
{
    private CurrencyEnum $currency = CurrencyEnum::SAR;

    public function __construct(
        private readonly MoneyCalculator $calculator,
        private readonly TaxQuery $taxQuery,
    )
    {
    }

    public function createPriceFromNett(Money $nett, ?CurrencyEnum $currency = null): PriceDto
    {
        $taxRate = $this->taxQuery->getRateByCurrency($currency ?? $this->currency);

        return new PriceDto(
            nett : $nett,
            gross: $this->calculator->calculateGross($nett, $taxRate),
            rate : $taxRate,
        );
    }

    public function createPriceFromGross(Money $gross, ?CurrencyEnum $currency = null): PriceDto
    {
        $taxRate = $this->taxQuery->getRateByCurrency($currency ?? $this->currency);

        return new PriceDto(
            nett : $this->calculator->calculateNett($gross, $taxRate),
            gross: $gross,
            rate : $taxRate,
        );
    }
}
