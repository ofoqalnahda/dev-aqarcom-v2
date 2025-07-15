<?php

declare(strict_types = 1);

namespace App\Component\Money\Domain\Exception;

class CurrencyException extends MoneyException
{
    public static function missingTaxRate(string $message = 'No tax rate set.'): self
    {
        return self::badRequest($message);
    }
}
