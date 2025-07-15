<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Exception\Application;

use Exception;
use Throwable;

abstract class ApplicationException extends Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
        private readonly array $context = [],
    )
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @see https://laravel.com/docs/10.x/errors#exception-log-context
     * @return array<string, mixed>
     */
    public function context(): array
    {
        return $this->context;
    }
}
