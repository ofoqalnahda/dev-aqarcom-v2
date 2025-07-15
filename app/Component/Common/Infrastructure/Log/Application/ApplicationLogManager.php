<?php

namespace App\Component\Common\Infrastructure\Log\Application;

use Illuminate\Log\Logger;
use Illuminate\Log\LogManager;
use Psr\Log\LoggerInterface;

class ApplicationLogManager extends LogManager
{
    /** @param mixed $name */
    protected function get(
        $name,
        ?array $config = null,
    ): LoggerInterface
    {
        $logger = parent::get($name, $config);

        if ($logger instanceof Logger) {
            $logger = $this->configureLogger($logger);
        }

        return $this->channels[$name] = $logger;
    }

    private function configureLogger(Logger $logger): Logger
    {
        return $logger
            ->withContext([
                'request_id'           => optional(request())->header(config('logging.request_id.header')),
                'is_user_authorized'   => auth()->check(),
                'authorized_user_uuid' => auth()->id(),
                'is_application_cli'   => $this->app->runningInConsole(),
                'is_application_debug' => $this->app->hasDebugModeEnabled(),
                'application_version'  => config('app.version'),
                'application_locale'   => $this->app->getLocale(),
                'framework_version'    => $this->app->version(),
                'php_version'          => PHP_VERSION,
                'log_source'           => 'api',
            ]);
    }
}
