<?php

namespace App\Component\Ad\Application\Repository;

use App\Component\Ad\Domain\Enum\MainType;
use App\Component\Ad\Infrastructure\Http\Request\CheckAdLicenseRequest;
use Illuminate\Contracts\Auth\Authenticatable;

interface AdRepository
{
    /**
     * Create a new ad.
     * @param MainType $mainType
     * @param $request
     * @param $user
     * @return mixed
     */
    public function create(MainType $mainType,$request, $user): mixed;

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
    public function filter(MainType $mainType, array $filters,$withDist=false);
    public function getDataForFilter(): array;
    public function findBySlug($slug);
}
