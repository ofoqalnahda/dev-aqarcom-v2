<?php

namespace App\Component\Ad\Infrastructure\ViewQuery;

use App\Component\Ad\Presentation\ViewQuery\AdViewQueryInterface;
use App\Component\Ad\Data\Entity\Ad\Ad;

class AdViewQuery implements AdViewQueryInterface
{
    public function list(array $filters = []): array
    {
        $query = Ad::query();
        // Apply filters if needed
        foreach ($filters as $key => $value) {
            $query->where($key, $value);
        }
        return $query->get()->toArray();
    }

    public function find(int|string $id): mixed
    {
        return Ad::find($id);
    }

}
