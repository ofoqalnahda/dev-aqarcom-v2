<?php

namespace App\Libraries\Phone;

use Exception;
use Illuminate\Support\Str;
use Propaganistas\LaravelPhone\PhoneNumber;

abstract class PhoneFormatter
{
    public static function getPrefix(string $fullPhone): string
    {
        return self::matchPhonePrefix($fullPhone);
    }

    public static function getPhoneWithoutPrefix(string $fullPhone): string
    {
        $prefix = self::matchPhonePrefix($fullPhone);

        return Str::after($fullPhone, $prefix);
    }

    /**
     * @param string $fullPhone
     * @deprecated Try to avoid this method. Focus on data validation, not sanitization!
     *
     */
    public static function getPhoneWithoutLeadingZeros(string $fullPhone): string
    {
        $prefix = self::getPrefix($fullPhone);
        $phone = self::getPhoneWithoutPrefix($fullPhone);

        return $prefix . ltrim($phone, '0');
    }

    public static function isPhoneInSaudiArabia(string $phoneNumber): bool
    {
        return self::isPhoneFromCountries($phoneNumber, ['SA']);
    }

    public static function isPhoneFromCountries(
        string $phoneNumber,
        array $countries,
    ): bool
    {
        try {
            return in_array(
                (new PhoneNumber($phoneNumber))->getCountry(),
                array_map('strval', $countries),
                true,
            );
        } catch (Exception) {
            return false;
        }
    }

    private static function matchPhonePrefix(string $fullPhone): string
    {
        $prefixes = config('app.country_codes');

        foreach ($prefixes as $prefix) {
            if (Str::startsWith($fullPhone, $prefix)) {
                return $prefix;
            }
        }

        throw new Exception('Invalid phone number. Prefix not allowed or not provided.');
    }
}
