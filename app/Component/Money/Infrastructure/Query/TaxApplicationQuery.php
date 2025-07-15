<?php

declare(strict_types = 1);

namespace App\Component\Money\Infrastructure\Query;

use App\Component\Money\Application\Query\TaxQuery;
use App\Component\Money\Domain\Enum\CurrencyEnum;
use App\Component\Money\Domain\Exception\CurrencyException;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Translation\Translator;

class TaxApplicationQuery implements TaxQuery
{
    public function __construct(
        private readonly Repository $config,
        private readonly Translator $translator,
    ) {
    }

    /** @throws CurrencyException */
    public function getRateByCurrency(CurrencyEnum $currency): int
    {
        $taxRate = (int) $this->config->get("money.tax.$currency->value");
        $taxRate = max(0, min(100, $taxRate));

        if ($taxRate === 0) {
            throw CurrencyException::missingTaxRate(
                $this->translator->get('money::exception.currency.missing_tax_rate', ['currencySymbol' => $currency->value]),
            );
        }

        return $taxRate;
    }
}
