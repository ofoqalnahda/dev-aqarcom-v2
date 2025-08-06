<?php

namespace App\Component\Ad\Infrastructure\Repository;

use App\Component\Ad\Application\Repository\CityRepository;
use App\Component\Ad\Data\Entity\Geography\City;

class CityRepositoryEloquent implements CityRepository
{

    public function index(): mixed
    {
        return City::get()->toArray();
    }
    public function create(array $data): mixed
    {

        return City::create($data);
    }

    public function update($id, array $data): mixed
    {
        $City = City::find($id);
        if ($City) {
            $City->update($data);
        }
        return $City;
    }
    public function find($id)
    {
        return City::find($id);
    }
    public function delete($id): bool
    {
        $City = City::find($id);
        if ($City) {
            return $City->delete();
        }
        return false;
    }
}
