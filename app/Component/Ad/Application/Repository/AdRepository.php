<?php

namespace App\Component\Ad\Application\Repository;

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
    public function findByLicenseNumber(string $license_number);
}
