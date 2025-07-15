<?php

namespace App\Libraries\Intl;

class Country
{
    public function __construct(
        private string $code,
        private Currency $currency,
        private Language $language,
        private Vat $vat,
    )
    {
    }

    public function code(): string
    {
        return $this->code;
    }

    public function currency(): string
    {
        return $this->currency->code();
    }

    public function locale(): string
    {
        return $this->language->locale();
    }

    public function vatRate(): int
    {
        return $this->vat->rate();
    }
}
