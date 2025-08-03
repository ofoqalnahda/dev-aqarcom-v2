<?php

namespace App\Component\Ad\Infrastructure\Service;

use AllowDynamicProperties;
use App\Component\Ad\Application\Service\EstateTypeServiceInterface;
use App\Component\Ad\Application\Repository\EstateTypeRepository;
use App\Component\Ad\Domain\Enum\MainType;
use Illuminate\Contracts\Auth\Authenticatable;


class EstateTypeService implements EstateTypeServiceInterface
{
    protected EstateTypeRepository $estateTypeRepository;

    public function __construct(EstateTypeRepository $estateTypeRepository)
    {
        $this->estateTypeRepository = $estateTypeRepository;
    }

    public function index(): mixed
    {
        return $this->estateTypeRepository->index();
    }
    public function update($id, array $data): mixed
    {
        return $this->estateTypeRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->estateTypeRepository->delete($id);
    }

    public function create( $data): mixed
    {
        return $this->estateTypeRepository->create( $data);
    }

    public function find(int|string $id): mixed
    {
        return $this->estateTypeRepository->find($id);
    }



}
