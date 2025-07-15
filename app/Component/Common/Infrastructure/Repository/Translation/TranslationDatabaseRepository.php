<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Repository\Translation;

use App\Component\Common\Domain\Enum\Application\LocaleEnum;
use Barryvdh\TranslationManager\Models\Translation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

class TranslationDatabaseRepository extends TranslationRepository
{
    public function listTranslationGroup(string $group, LocaleEnum $locale): Collection
    {
        return Translation::query()
            ->where('locale', '=', $locale)
            ->where('group', '=', $this->sanitize($group))
            ->get(['key', 'value'])
            ->pluck('value', 'key');
    }

    public function firstOrCreate(string $group, string $key, LocaleEnum $locale, ?string $value = null): Translation
    {
        $attributes = ['group' => $this->sanitize($group), 'key' => $this->sanitize($key), 'locale' => $locale->value];
        $translation = Translation::query()->firstWhere($attributes);
        $translation ??= Translation::query()->firstOrCreate([...$attributes, 'locale' => LocaleEnum::ENGLISH]);
        $value = ((string) $translation->value) === '' ? $value : $translation->value;

        if (! $translation->wasRecentlyCreated) {
            return $translation->fill(['value' => $value]);
        }

        Translation::query()->updateOrCreate(
            attributes: [...$attributes, 'locale' => ''],
            values: ['value' => $value],
        );

        foreach (LocaleEnum::cases() as $l) {
            Translation::query()->firstOrCreate(
                attributes: [...$attributes, 'locale' => $l],
                values: ['value' => $value]
            );
        }

        return $translation->fill(['value' => $value]);
    }

    public function listTranslations(
        ?string $group = null,
        ?string $key = null,
        ?LocaleEnum $locale = null,
    ): LazyCollection
    {
        return Translation::query()
            ->when($group, fn (Builder $q) => $q->where('group', '=', $this->sanitize($group)))
            ->when($key, fn (Builder $q) => $q->where('key', '=', $this->sanitize($key)))
            ->when($locale, fn (Builder $q) => $q->where('locale', '=', $locale))
            ->lazy();
    }

    public function listAvailableGroups(): Collection
    {
        return Translation::query()
            ->select('group')
            ->distinct()
            ->get()
            ->pluck('group');
    }
}
