<?php

namespace App\Component\Ad\Application\Repository;


interface ReasonRepository
{
    /**
     * index all items.
     * @return mixed
     */
    public function index(): mixed;
    /**
     * Create a new Reason.
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * Update  Reason by ID.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update(int|string $id, array $data): mixed;

    /**
     * Delete  Reason by ID.
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
}
