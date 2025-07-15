<?php

declare(strict_types = 1);

namespace App\Libraries\Base\Utilities;

use App\Component\Content\DomainModel\Source\Enum\SourceType;
use Illuminate\Http\Request;

trait RequestHasPlatform
{
    private function getPlatform(Request $request): ?string
    {
        $platform = $request->headers->get('platform');
        $platform = is_string($platform) ? strtolower($platform) : null;

        return match ($platform) {
            SourceType::DASHBOARD()->getValue(),
            SourceType::IOS()->getValue() => $platform,
            default => 'mobile',
        };
    }
}
