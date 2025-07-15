<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Resolver\Application;

use DateTimeZone;

class TimeZoneResolver
{
    public static function firstByIsoCountryCode(string $code, ?string $default = ''): ?string
    {
        if (! $code) {
            return $default;
        }

        return timezone_identifiers_list(DateTimeZone::PER_COUNTRY, mb_strtoupper($code))[0] ?? null;
    }
}
