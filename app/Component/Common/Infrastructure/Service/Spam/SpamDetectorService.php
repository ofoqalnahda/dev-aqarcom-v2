<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Service\Spam;

use App\Component\Common\Domain\Exception\Spam\SpamDetectorException;
use App\Component\Common\Infrastructure\Config\Spam\SpamDetectorConfig;
use Illuminate\Contracts\Cache\Repository;
use Psr\Log\LoggerInterface;

class SpamDetectorService
{
    public function __construct(
        private readonly Repository $cache,
        private readonly SpamDetectorConfig $config,
        private readonly LoggerInterface $logger,
    )
    {
    }

    /** @throws SpamDetectorException */
    public function detect(string $key): void
    {
        if (! $this->config->isEnabled()) {
            return;
        }

        if (in_array($key, $this->config->whitelist(), true)) {
            return;
        }

        $standardCacheId = $this->config->standardCacheId($key);
        $suspensionCacheId = $this->config->suspensionCacheId($key);

        $tries = (int) $this->cache->get($standardCacheId, 0) + 1;
        $suspensionTries = (int) $this->cache->get($suspensionCacheId, 0);

        match (true) {
            $tries <= 1 => $this->cache->put($standardCacheId, $tries, $this->config->standardTtl()),
            default => $this->cache->increment($standardCacheId),
        };

        $standardLimit = $this->config->standardLimit();
        $suspensionLimit = $this->config->suspensionLimit();
        $spamDetected = $tries >= $standardLimit || $suspensionTries >= $suspensionLimit;

        if ($spamDetected) {
            $suspensionTries++;
            $this->cache->put($suspensionCacheId, $suspensionTries, $this->config->suspensionTtl());
            $this->logger->info('[SPAM DETECTOR]', [
                'spam_detector'   => true,
                'key'             => $key,
                'tries'           => $tries,
                'suspensionTries' => $suspensionTries,
            ]);

            throw SpamDetectorException::tooManyAttempts();
        }
    }
}
