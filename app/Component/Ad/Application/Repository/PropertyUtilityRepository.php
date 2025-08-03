<?php

namespace App\Component\Ad\Application\Repository;

use App\Component\Ad\Domain\Enum\MainType;
use App\Component\Ad\Infrastructure\Http\Request\CheckAdLicenseRequest;
use Illuminate\Contracts\Auth\Authenticatable;

interface PropertyUtilityRepository
{
    /**
     * index all items.
     * @return mixed
     */
    public function index(): mixed;
    /**
     * Create a new Property Utility.
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * Update  Property Utility by ID.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update(int|string $id, array $data): mixed;

    /**
     * Delete  Property Utility by ID.
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
}
