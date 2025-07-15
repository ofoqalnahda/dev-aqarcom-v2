<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Service\Translation;

use App\Component\Common\Domain\Enum\Application\LocaleEnum;
use App\Component\Common\Infrastructure\Repository\Translation\TranslationRedisRepository;
use App\Component\Common\Infrastructure\Repository\Translation\TranslationDatabaseRepository;
use Barryvdh\TranslationManager\Models\Translation;

class TranslationService
{
    public function __construct(
        private readonly TranslationDatabaseRepository $databaseRepository,
        private readonly TranslationRedisRepository $cacheRepository,
    )
    {
    }

    public function getOrCreate(
        string $group,
        ?string $key,
        LocaleEnum $locale,
        ?string $defaultValue = null,
    ): array
    {
        if (! $key) {
            $cachedGroup = $this->cacheRepository->listTranslationGroup($group, $locale);

            if (! $cachedGroup) {
                $cachedGroup = $this->databaseRepository->listTranslationGroup($group, $locale);
                $this->cacheRepository->setTranslationGroup($group, $locale, $cachedGroup);
            }

            return collect($cachedGroup)->toArray();
        }

        $data = $this->cacheRepository->find($group, $key, $locale);

        if ($data) {
            return $data;
        }

        $translation = $this->databaseRepository->firstOrCreate($group, $key, $locale, $defaultValue);
        $notReady = $translation->wasRecentlyCreated || ! $translation->value;
        $value = $notReady ? "{$translation->group}.{$translation->key}" : $translation->value;

        return $this->cacheRepository->put($group, $key, $locale, ['value' => $value]);
    }

    public function invalidate(
        ?string $groupName = null,
        ?string $key = null,
        ?LocaleEnum $locale = null,
    ): void
    {
        $locales = $locale ? [$locale] : LocaleEnum::cases();

        foreach ($locales as $lang) {
            if (! $groupName && ! $key) {
                $availableGroups = $this->databaseRepository->listAvailableGroups();

                $availableGroups->each(fn (string $groupName) => $this->cacheRepository->setTranslationGroup(
                    groupName: $groupName,
                    locale: $lang,
                    group: $this->databaseRepository->listTranslationGroup($groupName, $lang),
                ));
            }

            if ($groupName && ! $key) {
                $this->cacheRepository->setTranslationGroup(
                    groupName: $groupName,
                    locale: $lang,
                    group: $this->databaseRepository->listTranslationGroup($groupName, $lang),
                );
            }

            $this->databaseRepository
                ->listTranslations($groupName, $key, $lang)
                ->each(fn (Translation $translation) => $this->cacheRepository->put(
                    group: $translation->group,
                    key: $translation->key,
                    locale: LocaleEnum::from($translation->locale),
                    value: ['value' => $translation->value],
                ));
        }
    }
}
