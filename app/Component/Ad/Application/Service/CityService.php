<?php

namespace App\Component\Ad\Application\Service;


interface CityService
{
    /**
     * index all items.
     * @return mixed
     */
    public function index(): mixed;
    /**
     * create a new City.
     * @param array $data
     * @return mixed
     */
    public function create( array $data): mixed;
    /**
     * Update City information.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update(int|string $id, array $data): mixed;

    /**
     * Delete a City.
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Fetch a City by ID.
     * @param int|string $id
     * @return mixed
     */
    public function find(int|string $id): mixed;
}
