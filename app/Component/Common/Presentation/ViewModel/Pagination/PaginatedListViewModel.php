<?php

declare(strict_types = 1);

namespace App\Component\Common\Presentation\ViewModel\Pagination;

use App\Component\Common\Domain\Dto\Pagination\PaginationMetadataDto;
use Illuminate\Support\Collection;

class PaginatedListViewModel
{
    public function __construct(
        private readonly Collection $collection,
        private readonly PaginationMetadataDto $metadata,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'data'     => $this->collection->toArray(),
            'metadata' => [
                'last_page' => $this->metadata->lastPage,
                'total'     => $this->metadata->total,
            ],
        ];
    }
}