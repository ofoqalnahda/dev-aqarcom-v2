<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Enum\List;

enum SortTypeEnum: string
{
    case ASCENDING = 'asc';
    case DESCENDING = 'desc';
}
