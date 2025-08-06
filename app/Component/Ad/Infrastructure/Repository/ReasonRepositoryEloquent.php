<?php

namespace App\Component\Ad\Infrastructure\Repository;

use App\Component\Ad\Application\Repository\ReasonRepository;
use App\Component\Ad\Data\Entity\Ad\Reason;
class ReasonRepositoryEloquent implements ReasonRepository
{

    public function index(): mixed
    {
        return Reason::get()->toArray();
    }
    public function create(array $data): mixed
    {

        return Reason::create($data);
    }

    public function update($id, array $data): mixed
    {
        $Reason = Reason::find($id);
        if ($Reason) {
            $Reason->update($data);
        }
        return $Reason;
    }
    public function find($id)
    {
        return Reason::find($id);
    }
    public function delete($id): bool
    {
        $Reason = Reason::find($id);
        if ($Reason) {
            return $Reason->delete();
        }
        return false;
    }
}
