<?php

namespace App\Component\Ad\Infrastructure\Repository;

use App\Component\Ad\Application\Repository\UsageTypeRepository;
use App\Component\Ad\Data\Entity\Ad\EstateType;
use App\Component\Ad\Data\Entity\Ad\UsageType;

class UsageTypeRepositoryEloquent implements UsageTypeRepository
{

    public function index(): mixed
    {
        return UsageType::get()->toArray();
    }
    public function create(array $data): mixed
    {

        return UsageType::create($data);
    }

    public function update($id, array $data): mixed
    {
        $UsageType = UsageType::find($id);
        if ($UsageType) {
            $UsageType->update($data);
        }
        return $UsageType;
    }
    public function find($id)
    {
        return UsageType::find($id);
    }
    public function delete($id): bool
    {
        $UsageType = UsageType::find($id);
        if ($UsageType) {
            return $UsageType->delete();
        }
        return false;
    }
}
