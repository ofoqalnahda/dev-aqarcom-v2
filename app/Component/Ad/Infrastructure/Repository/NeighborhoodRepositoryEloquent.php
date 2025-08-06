<?php

namespace App\Component\Ad\Infrastructure\Repository;

use App\Component\Ad\Application\Repository\NeighborhoodRepository;
use App\Component\Ad\Data\Entity\Geography\Neighborhood;

class NeighborhoodRepositoryEloquent implements NeighborhoodRepository
{

    public function index(): mixed
    {
        return Neighborhood::get()->toArray();
    }
    public function create(array $data): mixed
    {

        return Neighborhood::create($data);
    }

    public function update($id, array $data): mixed
    {
        $Neighborhood = Neighborhood::find($id);
        if ($Neighborhood) {
            $Neighborhood->update($data);
        }
        return $Neighborhood;
    }
    public function find($id)
    {
        return Neighborhood::find($id);
    }
    public function delete($id): bool
    {
        $Neighborhood = Neighborhood::find($id);
        if ($Neighborhood) {
            return $Neighborhood->delete();
        }
        return false;
    }
}
