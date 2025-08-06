<?php

namespace App\Component\Ad\Application\Service;


interface RegionMapService
{
    /**
     * index all items.
     * @return mixed
     */
    public function index(): mixed;
    /**
     * create a new Region Map.
     * @param array $data
     * @return mixed
     */
    public function create( array $data): mixed;
    /**
     * Update Region Map information.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update(int|string $id, array $data): mixed;

    /**
     * Delete a Region Map.
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Fetch a Region Map by ID.
     * @param int|string $id
     * @return mixed
     */
    public function find(int|string $id): mixed;
}
