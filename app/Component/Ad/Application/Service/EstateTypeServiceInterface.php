<?php

namespace App\Component\Ad\Application\Service;



interface EstateTypeServiceInterface
{
    /**
     * index all items.
     * @return mixed
     */
    public function index(): mixed;
    /**
     * create a new Estate Type .
     * @param  array $data
     * @return mixed
     */
    public function create(array $data): mixed;
    /**
     * Update Estate Type information.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update(int|string $id, array $data): mixed;

    /**
     * Delete Estate Type.
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Fetch  Estate Type by ID.
     * @param int|string $id
     * @return mixed
     */
    public function find(int|string $id): mixed;

}
