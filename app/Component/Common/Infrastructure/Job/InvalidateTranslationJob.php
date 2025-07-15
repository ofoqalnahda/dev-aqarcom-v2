<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Job;

use App\Component\Common\Infrastructure\Service\Translation\TranslationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvalidateTranslationJob implements ShouldQueue
{
    use Queueable;

    public function handle(TranslationService $translation): void
    {
        $translation->invalidate();
    }
}
