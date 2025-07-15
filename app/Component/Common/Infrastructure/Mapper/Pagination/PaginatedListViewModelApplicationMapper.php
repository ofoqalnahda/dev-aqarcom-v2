<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Mapper\Pagination;

use App\Component\Common\Application\Mapper\PaginatedListViewModelMapper;
use App\Component\Common\Domain\Dto\Pagination\PaginationMetadataDto;
use App\Component\Common\Presentation\ViewModel\Pagination\PaginatedListViewModel;
use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PaginatedListViewModelApplicationMapper implements PaginatedListViewModelMapper
{
    public function mapPaginatorToViewModel(
        LengthAwarePaginator $paginator,
        Closure $mapItems,
    ): PaginatedListViewModel
    {
        $collection = Collection
            ::make($paginator->items())
            ->map(static fn ($item) => $mapItems($item));

        return new PaginatedListViewModel(
            collection: $collection,
            metadata  : new PaginationMetadataDto(
                total      : $paginator->total(),
                lastPage   : $paginator->lastPage(),
            ),
        );
    }
}
