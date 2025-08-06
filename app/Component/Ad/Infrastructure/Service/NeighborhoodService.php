<?php

namespace App\Component\Ad\Infrastructure\Service;

use App\Component\Ad\Application\Service\NeighborhoodServiceInterface;
use App\Component\Ad\Application\Repository\NeighborhoodRepository;


class NeighborhoodService implements NeighborhoodServiceInterface
{
    protected NeighborhoodRepository $neighborhoodRepository;

    public function __construct(NeighborhoodRepository $neighborhoodRepository)
    {
        $this->neighborhoodRepository = $neighborhoodRepository;
    }

    public function update($id, array $data): mixed
    {
        return $this->neighborhoodRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->neighborhoodRepository->delete($id);
    }

    public function create( $data): mixed
    {
        return $this->neighborhoodRepository->create( $data);
    }

    public function find(int|string $id): mixed
    {
        return $this->neighborhoodRepository->find($id);
    }


    public function index(): mixed
    {
        return $this->neighborhoodRepository->index();

    }
}
