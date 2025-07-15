<?php

declare(strict_types = 1);

namespace App\Component\Common\Application\Mapper;

use App\Component\Common\Presentation\ViewModel\Pagination\PaginatedListViewModel;
use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PaginatedListViewModelMapper
{
    public function mapPaginatorToViewModel(
        LengthAwarePaginator $paginator,
        Closure $mapItems,
    ): PaginatedListViewModel;
}
