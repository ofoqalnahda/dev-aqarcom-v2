<?php

namespace App\Component\Ad\Infrastructure\Repository;

use App\Component\Ad\Application\Repository\RegionRepository;
use App\Component\Ad\Data\Entity\Geography\Region;

class RegionRepositoryEloquent implements RegionRepository
{

    public function index(): mixed
    {
        return Region::get()->toArray();
    }
    public function create(array $data): mixed
    {

        return Region::create($data);
    }

    public function update($id, array $data): mixed
    {
        $Region = Region::find($id);
        if ($Region) {
            $Region->update($data);
        }
        return $Region;
    }
    public function find($id)
    {
        return Region::find($id);
    }
    public function delete($id): bool
    {
        $Region = Region::find($id);
        if ($Region) {
            return $Region->delete();
        }
        return false;
    }
}
