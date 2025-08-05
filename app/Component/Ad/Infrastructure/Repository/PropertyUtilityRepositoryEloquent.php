<?php

namespace App\Component\Ad\Infrastructure\Repository;

use App\Component\Ad\Application\Repository\PropertyUtilityRepository;
use App\Component\Ad\Data\Entity\Ad\EstateType;
use App\Component\Ad\Data\Entity\Ad\PropertyUtility;

class PropertyUtilityRepositoryEloquent implements PropertyUtilityRepository
{
    public function index(): mixed
    {
        return EstateType::get()->toArray();
    }

    public function create(array $data): mixed
    {

        return PropertyUtility::create($data);
    }

    public function update($id, array $data): mixed
    {
        $PropertyUtility = PropertyUtility::find($id);
        if ($PropertyUtility) {
            $PropertyUtility->update($data);
        }
        return $PropertyUtility;
    }
    public function find($id)
    {
        return PropertyUtility::find($id);
    }
    public function delete($id): bool
    {
        $PropertyUtility = PropertyUtility::find($id);
        if ($PropertyUtility) {
            return $PropertyUtility->delete();
        }
        return false;
    }
}
