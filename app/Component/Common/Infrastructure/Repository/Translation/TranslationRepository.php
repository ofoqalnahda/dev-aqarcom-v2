<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Repository\Translation;

abstract class TranslationRepository
{
    protected function sanitize(string $value): string
    {
        return str(iconv('UTF-8', 'ASCII//TRANSLIT', $value))
            ->trim()
            ->lower()
            ->replace('/[^a-z0-9_]/', ' ')
            ->replace('/\s+/', ' ')
            ->trim()
            ->replace(' ', '_')
            ->toString();
    }
}
