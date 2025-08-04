<?php

namespace App\Component\Payments\Domain\Exception;

use Exception;

class InvalidPromoCodeException extends Exception
{
    public static function codeNotFound(string $code): self
    {
        return new self("Promo code '{$code}' not found.");
    }

    public static function codeExpired(string $code): self
    {
        return new self("Promo code '{$code}' has expired.");
    }

    public static function codeUsageLimitReached(string $code): self
    {
        return new self("Promo code '{$code}' usage limit has been reached.");
    }

    public static function codeInactive(string $code): self
    {
        return new self("Promo code '{$code}' is inactive.");
    }

    public static function minimumAmountNotMet(string $code, float $minimumAmount): self
    {
        return new self("Promo code '{$code}' requires a minimum amount of {$minimumAmount}.");
    }

    public static function notApplicableToPackage(string $code, int $packageId): self
    {
        return new self("Promo code '{$code}' is not applicable to package ID {$packageId}.");
    }
} 