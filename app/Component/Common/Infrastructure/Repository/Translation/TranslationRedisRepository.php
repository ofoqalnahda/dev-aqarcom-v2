<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Repository\Translation;

use App\Component\Common\Domain\Enum\Application\LocaleEnum;
use Illuminate\Support\Collection;

class TranslationRedisRepository extends TranslationRepository
{
    public function __construct(private readonly TranslationRedisStore $redisStore)
    {
    }

    public function find(string $group, string $key, LocaleEnum $locale): ?array
    {
        return $this->redisStore->get(
            $this->cacheKey($group, $key, $locale)
        );
    }

    public function put(string $group, string $key, LocaleEnum $locale, array $value): array
    {
        $cacheKey = $this->cacheKey($group, $key, $locale);
        $this->redisStore->forever(json_encode($value), $cacheKey);

        return $value;
    }

    public function listTranslationGroup(string $group, LocaleEnum $locale): ?array
    {
        return $this->redisStore->get($this->cacheKey($group, locale: $locale));
    }

    public function setTranslationGroup(string $groupName, LocaleEnum $locale, Collection $group): void
    {
        $i18n = (array) ($this->redisStore->get($this->cacheKey('i18n')) ?? []);
        $i18n[$locale->value][$groupName] = $group->toArray();

        $locales = (array) ($this->redisStore->get($this->cacheKey('locales')) ?? []);
        $locales[] = $locale->value;
        $locales = array_unique($locales);

        $this->redisStore->forever($this->cacheKey('locales'), $locales);
        $this->redisStore->forever($this->cacheKey('i18n'), $i18n);

        $this->redisStore->forever(
            $this->cacheKey($groupName, locale: $locale),
            json_encode($group->toArray()),
        );
    }

    private function cacheKey(
        string $group,
        ?string $key = null,
        ?LocaleEnum $locale = null,
    ): string
    {
        return 'translation.' . implode('.', array_filter([
            'group'  => $this->sanitize($group),
            'key'    => $key ? $this->sanitize($key) : null,
            'locale' => $locale?->value,
        ]));
    }
}
