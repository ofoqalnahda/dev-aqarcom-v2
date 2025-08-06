<?php

namespace App\Component\Ad\Infrastructure\Repository;

use App\Component\Ad\Application\Repository\RegionMapRepository;
use App\Component\Ad\Data\Entity\Geography\RegionMap;

class RegionMapRepositoryEloquent implements RegionMapRepository
{

    public function index(): mixed
    {
        return RegionMap::get()->toArray();
    }
    public function create(array $data): mixed
    {

        return RegionMap::create($data);
    }

    public function update($id, array $data): mixed
    {
        $RegionMap = RegionMap::find($id);
        if ($RegionMap) {
            $RegionMap->update($data);
        }
        return $RegionMap;
    }
    public function find($id)
    {
        return RegionMap::find($id);
    }
    public function delete($id): bool
    {
        $RegionMap = RegionMap::find($id);
        if ($RegionMap) {
            return $RegionMap->delete();
        }
        return false;
    }
}
