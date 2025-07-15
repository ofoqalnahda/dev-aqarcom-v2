<?php

namespace App\Libraries\Base\Database;

use Closure;

/** @deprecated Use Illuminate\Database\Connection instead */
interface ConnectionService
{
    public function disableLog(): void;

    /** @deprecated use transaction() */
    public function beginTransaction(): void;

    /** @deprecated use transaction() */
    public function commit(): void;

    /** @deprecated use transaction() */
    public function rollBack(): void;

    public function transaction(
        Closure $callback,
        int $attempts = 5,
    ): void;
}
