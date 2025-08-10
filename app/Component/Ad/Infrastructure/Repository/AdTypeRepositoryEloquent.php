<?php

namespace App\Component\Ad\Infrastructure\Repository;

use App\Component\Ad\Application\Repository\AdTypeRepository;
use App\Component\Ad\Data\Entity\Ad\AdType;
use App\Component\Ad\Domain\Enum\MainType;

class AdTypeRepositoryEloquent implements AdTypeRepository
{


    public function create(array $data): mixed
    {

        return AdType::create($data);
    }

    public function update($id, array $data): mixed
    {
        $AdType = AdType::find($id);
        if ($AdType) {
            $AdType->update($data);
        }
        return $AdType;
    }
    public function find($id)
    {
        return AdType::find($id);
    }
    public function delete($id): bool
    {
        $AdType = AdType::find($id);
        if ($AdType) {
            return $AdType->delete();
        }
        return false;
    }

    public function getByType(string $type)
    {
        return AdType::where('main_type',$type)->get()
            ->toArray();
    }
}
