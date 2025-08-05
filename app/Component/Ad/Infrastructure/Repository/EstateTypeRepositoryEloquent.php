<?php

namespace App\Component\Ad\Infrastructure\Repository;

use App\Component\Ad\Application\Repository\EstateTypeRepository;
use App\Component\Ad\Data\Entity\Ad\EstateType;

class EstateTypeRepositoryEloquent implements EstateTypeRepository
{

    public function index(): mixed
    {
        return EstateType::orderBy('is_most_used', 'desc')->get()->toArray();
    }
    public function create(array $data): mixed
    {

        return EstateType::create($data);
    }

    public function update($id, array $data): mixed
    {
        $EstateType = EstateType::find($id);
        if ($EstateType) {
            $EstateType->update($data);
        }
        return $EstateType;
    }
    public function find($id)
    {
        return EstateType::find($id);
    }
    public function delete($id): bool
    {
        $EstateType = EstateType::find($id);
        if ($EstateType) {
            return $EstateType->delete();
        }
        return false;
    }


}
