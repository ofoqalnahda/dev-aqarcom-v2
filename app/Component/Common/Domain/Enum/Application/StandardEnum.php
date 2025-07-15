<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Enum\Application;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/** @template T */
trait StandardEnum
{
    public static function tryCreate(?string $value): ?self
    {
        return $value !== null && $value !== ''
            ? self::tryFrom($value)
            : null;
    }

    /** @return array<string> */
    public static function keys(): array
    {
        return array_keys(self::values());
    }

    /** @return array<string|int, string> */
    public static function values(?array $cases = null): array
    {
        return array_column($cases ?? self::cases(), 'value', 'name');
    }

    /** @return array<string> */
    public static function toArray(): array
    {
        return self::values();
    }

    public static function toCollection(): Collection
    {
        return collect(self::values());
    }

    /** @return array<string> */
    public static function options(): array
    {
        $data = [];

        foreach (self::toArray() as $value) {
            $data[$value] = Str::of($value)->headline()->value();
        }

        return $data;
    }

    public static function toString(string $separator = ','): string
    {
        return implode($separator, self::toArray());
    }

    /** @return array<T> */
    public static function except(self ...$exclude): array
    {
        return array_filter(
            self::cases(),
            static fn (self $enum) => ! in_array($enum, $exclude, true)
        );
    }
}
