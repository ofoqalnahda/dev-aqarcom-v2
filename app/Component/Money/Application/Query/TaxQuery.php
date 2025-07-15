<?php

declare(strict_types = 1);

namespace App\Component\Money\Application\Query;

use App\Component\Money\Domain\Enum\CurrencyEnum;

interface TaxQuery
{
    public function getRateByCurrency(CurrencyEnum $currency): int;
}
