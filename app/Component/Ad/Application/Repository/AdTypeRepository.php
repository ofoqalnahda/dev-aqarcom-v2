<?php

namespace App\Component\Ad\Application\Repository;

use App\Component\Ad\Domain\Enum\MainType;
use App\Component\Ad\Infrastructure\Http\Request\CheckAdLicenseRequest;
use Illuminate\Contracts\Auth\Authenticatable;

interface AdTypeRepository
{
    /**
     * Create a new Type Ad.
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * Update  Type Ad by ID.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update(int|string $id, array $data): mixed;

    /**
     * Delete  Type Ad by ID.
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
    public function getByType(string $type);

}
