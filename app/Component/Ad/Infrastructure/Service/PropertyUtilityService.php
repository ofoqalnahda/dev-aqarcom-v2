<?php

namespace App\Component\Ad\Infrastructure\Service;

use AllowDynamicProperties;
use App\Component\Ad\Application\Service\PropertyUtilityServiceInterface;
use App\Component\Ad\Application\Repository\PropertyUtilityRepository;
use App\Component\Ad\Domain\Enum\MainType;
use Illuminate\Contracts\Auth\Authenticatable;


class PropertyUtilityService implements PropertyUtilityServiceInterface
{
    protected PropertyUtilityRepository $propertyUtilityRepository;

    public function __construct(PropertyUtilityRepository $propertyUtilityRepository)
    {
        $this->propertyUtilityRepository = $propertyUtilityRepository;
    }

    public function update($id, array $data): mixed
    {
        return $this->propertyUtilityRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->propertyUtilityRepository->delete($id);
    }

    public function create( $data): mixed
    {
        return $this->propertyUtilityRepository->create( $data);
    }

    public function find(int|string $id): mixed
    {
        return $this->propertyUtilityRepository->find($id);
    }


    public function index(): mixed
    {
        return $this->propertyUtilityRepository->index();

    }
}
