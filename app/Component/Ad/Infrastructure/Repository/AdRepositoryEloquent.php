<?php

namespace App\Component\Ad\Infrastructure\Repository;

use App\Component\Ad\Application\Repository\AdRepository;
use App\Component\Ad\Data\Entity\Ad\Ad;

class AdRepositoryEloquent implements AdRepository
{
    public function create(array $data)
    {
        return Ad::create($data);
    }

    public function update($id, array $data)
    {
        $user = Ad::find($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }

    public function delete($id): bool
    {
        $user = Ad::find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }

    public function findByLicenseNumber(string $license_number)
    {
        // TODO: Implement findByLicenseNumber() method.
    }
}
