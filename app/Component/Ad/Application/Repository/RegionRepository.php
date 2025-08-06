<?php

namespace App\Component\Ad\Application\Repository;


interface RegionRepository
{
    /**
     * index all items.
     * @return mixed
     */
    public function index(): mixed;
    /**
     * Create a new Region.
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * Update  Region by ID.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update(int|string $id, array $data): mixed;

    /**
     * Delete  Region by ID.
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
}
