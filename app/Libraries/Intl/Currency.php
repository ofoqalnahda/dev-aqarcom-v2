<?php

namespace App\Libraries\Intl;

class Currency
{
    public function __construct(private string $code)
    {
    }

    public function code(): string
    {
        return $this->code;
    }
}
