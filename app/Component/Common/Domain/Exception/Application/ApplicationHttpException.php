<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Exception\Application;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

abstract class ApplicationHttpException extends ApplicationException implements HttpExceptionInterface
{
    public function __construct(
        string $message,
        private readonly int $statusCode = Response::HTTP_BAD_REQUEST,
        private readonly array $headers = [],
        private readonly array $context = [],
    )
    {
        parent::__construct($message, $statusCode, context: $this->context);
    }

    protected static function badRequest(
        string $message,
        array $headers = [],
        array $context = [],
    ): static
    {
        return new static($message, Response::HTTP_BAD_REQUEST, $headers, $context);
    }

    protected static function notFound(
        string $message,
        array $headers = [],
        array $context = [],
    ): static
    {
        return new static($message, Response::HTTP_NOT_FOUND, $headers, $context);
    }

    protected static function conflict(
        string $message,
        array $headers = [],
        array $context = [],
    ): static
    {
        return new static($message, Response::HTTP_CONFLICT, $headers, $context);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
