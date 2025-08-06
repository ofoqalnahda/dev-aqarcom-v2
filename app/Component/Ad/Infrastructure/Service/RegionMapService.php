<?php

namespace App\Component\Ad\Infrastructure\Service;

use App\Component\Ad\Application\Service\RegionMapServiceInterface;
use App\Component\Ad\Application\Repository\RegionMapRepository;


class RegionMapService implements RegionMapServiceInterface
{
    protected RegionMapRepository $regionMapRepository;

    public function __construct(RegionMapRepository $regionMapRepository)
    {
        $this->regionMapRepository = $regionMapRepository;
    }

    public function update($id, array $data): mixed
    {
        return $this->regionMapRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->regionMapRepository->delete($id);
    }

    public function create( $data): mixed
    {
        return $this->regionMapRepository->create( $data);
    }

    public function find(int|string $id): mixed
    {
        return $this->regionMapRepository->find($id);
    }


    public function index(): mixed
    {
        return $this->regionMapRepository->index();

    }
}
