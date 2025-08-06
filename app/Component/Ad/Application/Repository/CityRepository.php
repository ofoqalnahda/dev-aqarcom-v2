<?php

namespace App\Component\Ad\Application\Repository;


interface CityRepository
{
    /**
     * index all items.
     * @return mixed
     */
    public function index(): mixed;
    /**
     * Create a new City.
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * Update  City by ID.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update(int|string $id, array $data): mixed;

    /**
     * Delete  City by ID.
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
}
