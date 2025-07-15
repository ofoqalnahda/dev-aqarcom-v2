<?php

declare(strict_types = 1);

namespace App\Libraries\Base\Rules;

class FlightNumberRule extends Rule
{
    public const PATTERN = '^[A-Z]{2,3}\s?\d{3,4}$';

    /**
     * @param string|mixed $attribute
     * @param mixed $value
     */
    public function passes(
        $attribute,
        $value,
    ): bool
    {
        return (bool) preg_match($this->pattern(), $value);
    }

    public function message(): string
    {
        return $this->getLocalizedErrorMessage(
            'flight_number',
            'Provided :attribute is invalid',
        );
    }

    private function pattern(): string
    {
        return sprintf('/%s/', self::PATTERN);
    }
}
