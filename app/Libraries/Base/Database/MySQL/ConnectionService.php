<?php

declare(strict_types = 1);

namespace App\Libraries\Base\Database\MySQL;

use App\Libraries\Base\Database;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ConnectionService implements Database\ConnectionService
{

    private static bool $isLocked = false;

    /** @throws Throwable */
    public function transaction(
        Closure $callback,
        int $attempts = 5,
    ): void
    {
        for ($i = 0; $i < $attempts; $i++) {
            try {
                $this->beginTransaction();
                $callback();
                $this->commit();

                return;
            } catch (Throwable $exception) {
                Log::error($exception->getMessage(), [
                    'attempt' => $i,
                    'trace'   => $exception->getTrace(),
                ]);
                $this->rollBack();

                sleep(3);
                continue;
            }
        }

        if (isset($exception) === true) {
            throw $exception;
        }
    }

    public function disableLog(): void
    {
        DB::disableQueryLog();
        DB::unsetEventDispatcher();
        DB::connection('mysql')->disableQueryLog();
        DB::connection('mysql')->unsetEventDispatcher();
    }

    /** @throws Throwable */
    public function beginTransaction(): void
    {
        if (self::$isLocked) {
            return;
        }

        DB::connection('mysql')->beginTransaction();
        self::$isLocked = true;
    }

    /** @throws Throwable */
    public function commit(): void
    {
        DB::connection('mysql')->commit();
        self::$isLocked = false;
    }

    /** @throws Throwable */
    public function rollBack(): void
    {
        DB::connection('mysql')->rollBack();
        self::$isLocked = false;
    }
}
