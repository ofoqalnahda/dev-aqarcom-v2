<?php

declare(strict_types = 1);

use App\Component\Money\Domain\Enum\CurrencyEnum;

return [
    CurrencyEnum::SAR->value => env('MONEY_TAX_CURRENCY_SAR', 15),
];
