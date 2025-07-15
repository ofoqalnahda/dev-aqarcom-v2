<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Resolver\Application;

class CountryResolver
{
    public static function findNameByIsoCode(string $code): ?string
    {
        $countryName = locale_get_display_region(
            locale: sprintf("-%s", mb_strtoupper($code)),
            displayLocale: 'en',
        );

        return $countryName ?: null;
    }
}
