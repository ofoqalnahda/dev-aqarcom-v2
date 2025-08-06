<?php

namespace App\Component\Ad\Infrastructure\Service;

use App\Component\Ad\Application\Service\RegionServiceInterface;
use App\Component\Ad\Application\Repository\RegionRepository;


class RegionService implements RegionServiceInterface
{
    protected RegionRepository $regionRepository;

    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    public function update($id, array $data): mixed
    {
        return $this->regionRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->regionRepository->delete($id);
    }

    public function create( $data): mixed
    {
        return $this->regionRepository->create( $data);
    }

    public function find(int|string $id): mixed
    {
        return $this->regionRepository->find($id);
    }


    public function index(): mixed
    {
        return $this->regionRepository->index();

    }
}
