<?php

namespace App\Libraries\Intl;

class Language
{
    public function __construct(private string $locale)
    {
    }

    public function locale(): string
    {
        return $this->locale;
    }
}
