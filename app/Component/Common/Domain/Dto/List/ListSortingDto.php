<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Dto\List;

use App\Component\Common\Domain\Enum\List\SortTypeEnum;
use BackedEnum;

class ListSortingDto
{
    public function __construct(
        public readonly string $columnName,
        public readonly SortTypeEnum $type
    )
    {
    }

    public static function asc(string $columnName): self
    {
        return new self($columnName, SortTypeEnum::ASCENDING);
    }

    public static function desc(string $columnName): self
    {
        return new self($columnName, SortTypeEnum::DESCENDING);
    }

    /**
     * @template T of BackedEnum
     * @param class-string<T> $columnEnum
     * @return ?T
     */
    public function column(string $columnEnum): ?BackedEnum
    {
        if (is_a($columnEnum, BackedEnum::class, allow_string: true)) {
            return $columnEnum::tryFrom($this->columnName);
        }

        return null;
    }

    public function type(): string
    {
        return str($this->type->value)->upper()->toString();
    }
}
