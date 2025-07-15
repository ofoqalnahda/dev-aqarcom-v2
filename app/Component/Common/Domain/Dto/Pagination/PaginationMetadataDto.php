<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Dto\Pagination;

class PaginationMetadataDto
{
    public function __construct(
        public readonly int $total,
        public readonly int $lastPage,
    )
    {
    }
}
