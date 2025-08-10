<?php

namespace App\Component\Ad\Infrastructure\Service;

use AllowDynamicProperties;
use App\Component\Ad\Application\Service\AdTypeServiceInterface;
use App\Component\Ad\Application\Repository\AdTypeRepository;
use App\Component\Ad\Domain\Enum\MainType;
use Illuminate\Contracts\Auth\Authenticatable;


class AdTypeService implements AdTypeServiceInterface
{
    protected AdTypeRepository $adRepository;

    public function __construct(AdTypeRepository $adRepository)
    {
        $this->adRepository = $adRepository;
    }

    public function update($id, array $data): mixed
    {
        return $this->adRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->adRepository->delete($id);
    }

    public function create( $data): mixed
    {
        return $this->adRepository->create( $data);
    }

    public function find(int|string $id): mixed
    {
        return $this->adRepository->find($id);
    }


    public function getByType(string $type)
    {
        return $this->adRepository->getByType($type);
    }
}
