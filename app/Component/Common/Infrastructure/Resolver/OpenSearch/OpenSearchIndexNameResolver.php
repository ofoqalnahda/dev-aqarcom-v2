<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Resolver\OpenSearch;

use App\Component\Common\Domain\Enum\OpenSearch\OpenSearchIndexNameEnum;
use Illuminate\Support\Facades\App;

class OpenSearchIndexNameResolver
{
    public static function get(OpenSearchIndexNameEnum|string $name): string
    {
        $name = $name instanceof OpenSearchIndexNameEnum ? $name->value : $name;
        $env = App::environment();

        return "$name-$env";
    }

    public static function carSearchEngine(?string $alias = null): string
    {
        return self::get($alias ?: OpenSearchIndexNameEnum::CAR_SEARCH_ENGINE);
    }

    public static function locationApi(): string
    {
        return self::get(OpenSearchIndexNameEnum::LOCATION_API);
    }
}
