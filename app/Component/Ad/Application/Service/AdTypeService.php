<?php

namespace App\Component\Ad\Application\Service;

use App\Component\Ad\Domain\Enum\MainType;

interface AdTypeService
{
    /**
     * create a new Type Ad.
     * @param array $data
     * @return mixed
     */
    public function create( array $data): mixed;
    /**
     * Update Type Ad information.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update(int|string $id, array $data): mixed;

    /**
     * Delete a Type Ad.
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Fetch a Type Ad by ID.
     * @param int|string $id
     * @return mixed
     */
    public function find(int|string $id): mixed;

    public function getByType(MainType $type);
}
