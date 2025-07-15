<?php

declare(strict_types = 1);

namespace App\Component\Common\Application\Counter;

use Illuminate\Support\Traits\Tappable;
use LogicException;
use OverflowException;

class Counter
{
    public const NO_OVERFLOW = 1;
    public const INCREASING = 2;
    public const DECREASING = 4;

    private function __construct(
        private int $count,
        private readonly int $limit,
        private readonly int $mode,
    )
    {
        $this->checkCountingMode();
    }

    public static function decreasingWithoutOverflow(int $count, int $limit = 0): self
    {
        return new self(
            count: $count,
            limit: $limit,
            mode: self::NO_OVERFLOW | self::DECREASING,
        );
    }

    public function fulfilled(): bool
    {
        return $this->value() === 0;
    }

    public function count(): void
    {
        match (true) {
            $this->hasMode(self::INCREASING) => $this->count++,
            $this->hasMode(self::DECREASING) => $this->count--,
            default => throw new LogicException('Counting mode is set incorrectly.'),
        };

        $this->checkOverflow();
    }

    public function value(): int
    {
        return $this->count;
    }

    private function hasMode(int $mode): bool
    {
        return ($this->mode & $mode) === $mode;
    }

    private function checkCountingMode(): void
    {
        if ($this->hasMode(self::INCREASING) && $this->hasMode(self::DECREASING)) {
            throw new LogicException('Counting mode cannot me [increasing] and [decreasing] at the same time.');
        }

        if ($this->hasMode(self::INCREASING)) {
            return;
        }

        if ($this->hasMode(self::DECREASING)) {
            return;
        }

        throw new LogicException('Counter have to be either [increasing] or [decreasing].');
    }

    private function checkOverflow(): void
    {
        $limitReached = match (true) {
            $this->hasMode(self::INCREASING) => $this->count > $this->limit,
            $this->hasMode(self::DECREASING) => $this->count < $this->limit,
            default => throw new LogicException('Counting mode is set incorrectly.'),
        };

        if ($limitReached && $this->hasMode(self::NO_OVERFLOW)) {
            throw new OverflowException(sprintf(
                'Counter calls overflowed. Count [%d] Limit [%d]',
                $this->count,
                $this->limit,
            ));
        }
    }
}
