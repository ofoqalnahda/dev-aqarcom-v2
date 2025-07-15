<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Config\Spam;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Carbon;

class SpamDetectorConfig
{
    public function __construct(private readonly Repository $config)
    {
    }

    public function standardCacheId(string $key): string
    {
        return sprintf('%s:%s', $this->config->get('spam_detector.prefix'), $key);
    }

    public function isEnabled(): bool
    {
        return (bool) $this->config->get('spam_detector.enabled');
    }

    public function whitelist(): array
    {
        return $this->config->get('spam_detector.whitelist') ?: [];
    }

    public function suspensionCacheId(string $key): string
    {
        return $this->standardCacheId("$key:suspension");
    }

    public function standardTtl(): Carbon
    {
        return Carbon::now()->addMinutes(
            $this->config->get('spam_detector.ttl.standard') ?: 10,
        );
    }

    public function suspensionTtl(): Carbon
    {
        return Carbon::now()->addMinutes(
            $this->config->get('spam_detector.ttl.suspension') ?: 360,
        );
    }

    public function standardLimit(): int
    {
        return $this->config->get('spam_detector.limit.standard') ?: 5;
    }

    public function suspensionLimit(): int
    {
        return $this->config->get('spam_detector.limit.suspension') ?: 30;
    }
}
