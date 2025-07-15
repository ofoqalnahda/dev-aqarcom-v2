<?php

namespace App\Component\Common\Application\Mapper;

use Illuminate\Support\Collection;

interface EntityCollectionToViewModelCollectionMapper
{
    public function map(Collection $entityCollection): Collection;
}
