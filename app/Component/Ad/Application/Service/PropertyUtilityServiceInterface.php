<?php

namespace App\Component\Ad\Application\Service;



interface PropertyUtilityServiceInterface
{
    /**
     * index all items.
     * @return mixed
     */
    public function index(): mixed;
    /**
     * create a new Property Utility .
     * @param  array $data
     * @return mixed
     */
    public function create(array $data): mixed;
    /**
     * Update Property Utility information.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update(int|string $id, array $data): mixed;

    /**
     * Delete Property Utility.
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Fetch  Property Utility by ID.
     * @param int|string $id
     * @return mixed
     */
    public function find(int|string $id): mixed;

}
