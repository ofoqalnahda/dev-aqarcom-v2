<?php

namespace App\Libraries\Curl\Response;

final class Error
{
    public function __construct(
        private int $code,
        private string $message,
    )
    {
    }

    public function code(): int
    {
        return $this->code;
    }

    public function hasError(): bool
    {
        return $this->code() > 0;
    }

    public function message(): string
    {
        return $this->message;
    }
}
