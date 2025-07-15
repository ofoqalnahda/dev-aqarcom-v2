<?php

namespace App\Libraries\Support;

use Illuminate\Support\Collection;

class Counter
{
    private const EMPTY_COUNT = 0;
    private const INITIAL_COUNTER = 0;

    private int $counter;

    public function __construct(private int $total)
    {
        $this->counter = self::INITIAL_COUNTER;
    }

    public static function byCollection(Collection $collection): self
    {
        return new self($collection->count());
    }

    /**
     * @param int $count
     *
     * @return $this
     */
    public function increment(int $count = 1): self
    {
        $this->counter += $count;

        return $this;
    }

    /**
     * @param int $count
     *
     * @return $this
     */
    public function decrement(int $count = 1): self
    {
        $this->counter -= $count;

        return $this;
    }

    public function totalIsEmpty(): bool
    {
        return $this->total === self::EMPTY_COUNT;
    }

    public function isFulfilled(bool $allowEmptyTotal = false): bool
    {
        if (! $allowEmptyTotal && $this->totalIsEmpty()) {
            return false;
        }

        return $this->counter === $this->total;
    }
}
