<?php

declare(strict_types = 1);

namespace App\Component\Common\Application\Criteria;

use App\Component\Common\Domain\Dto\List\ListSortingDto;

interface ListCriteria
{
    public function search(): ?string;
    public function perPage(): int;
    public function page(): int;
    public function sorting(): ?ListSortingDto;
}
