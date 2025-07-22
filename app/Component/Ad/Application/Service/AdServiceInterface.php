<?php

namespace App\Component\Ad\Application\Service;

use App\Component\Ad\Infrastructure\Http\Request\CheckAdLicenseRequest;
use Illuminate\Contracts\Auth\Authenticatable;

interface AdServiceInterface
{
    /**
     * create a new ad.
     * @param array $data
     * @return mixed
     */
    public function create(array $data);
    /**
     * Update ad information.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Delete an ad.
     * @param int|string $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * Fetch an ad by ID.
     * @param int|string $id
     * @return mixed
     */
    public function find($id);

    /**
     * Check if Already exists.
     * @param int|string $license_number
     * @return mixed
     */
    public function CheckIsExitAd(int|string $license_number): mixed;

    public function CheckAdLicense(CheckAdLicenseRequest $request, ?Authenticatable $user);
}
