<?php

namespace App\Component\Ad\Application\Service;

use App\Component\Ad\Domain\Enum\MainType;

interface AdService
{
    /**
     * create a new ad.
     * @param MainType $mainType
     * @param $request
     * @param $user
     * @return mixed
     */
    public function create( MainType $mainType, $request, $user): mixed;
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
