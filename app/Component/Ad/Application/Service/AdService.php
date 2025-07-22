<?php

namespace App\Component\Ad\Application\Service;

interface AdService
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
}
