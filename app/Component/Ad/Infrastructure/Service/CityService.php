<?php

namespace App\Component\Ad\Infrastructure\Service;

use App\Component\Ad\Application\Service\CityServiceInterface;
use App\Component\Ad\Application\Repository\CityRepository;


class CityService implements CityServiceInterface
{
    protected CityRepository $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function update($id, array $data): mixed
    {
        return $this->cityRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->cityRepository->delete($id);
    }

    public function create( $data): mixed
    {
        return $this->cityRepository->create( $data);
    }

    public function find(int|string $id): mixed
    {
        return $this->cityRepository->find($id);
    }


    public function index(): mixed
    {
        return $this->cityRepository->index();

    }
}
