<?php

namespace App\Component\Ad\Application\Service;



interface RegionServiceInterface
{
    /**
     * index all items.
     * @return mixed
     */
    public function index(): mixed;
    /**
     * create a new Region .
     * @param  array $data
     * @return mixed
     */
    public function create(array $data): mixed;
    /**
     * Update Region information.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update(int|string $id, array $data): mixed;

    /**
     * Delete Region.
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Fetch  Region by ID.
     * @param int|string $id
     * @return mixed
     */
    public function find(int|string $id): mixed;

}
