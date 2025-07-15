<?php

namespace App\Libraries\Intl;

class Vat
{
    public function __construct(private int $rate)
    {
    }

    public function rate(): int
    {
        return $this->rate;
    }
}
