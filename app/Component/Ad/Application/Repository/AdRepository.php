<?php

namespace App\Component\Ad\Application\Repository;

use App\Component\Ad\Infrastructure\Http\Request\CheckAdLicenseRequest;
use Illuminate\Contracts\Auth\Authenticatable;

interface AdRepository
{
    /**
     * Create a new ad.
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update an ad by ID.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update(int|string $id, array $data);

    /**
     * Delete an ad by ID.
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Find an ad by license_number.
     * @param string $license_number
     * @return mixed
     */
    public function findByLicenseNumber(string $license_number): mixed;
    public function CheckIsExitAd(string $license_number);

    public function CheckAdLicense(CheckAdLicenseRequest $request, ?Authenticatable $user);
}
