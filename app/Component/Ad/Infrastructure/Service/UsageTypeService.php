<?php

namespace App\Component\Ad\Infrastructure\Service;

use AllowDynamicProperties;
use App\Component\Ad\Application\Service\UsageTypeServiceInterface;
use App\Component\Ad\Application\Repository\UsageTypeRepository;
use App\Component\Ad\Domain\Enum\MainType;
use Illuminate\Contracts\Auth\Authenticatable;


class UsageTypeService implements UsageTypeServiceInterface
{
    protected UsageTypeRepository $usageTypeRepository;

    public function __construct(UsageTypeRepository $usageTypeRepository)
    {
        $this->usageTypeRepository = $usageTypeRepository;
    }

    public function update($id, array $data): mixed
    {
        return $this->usageTypeRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->usageTypeRepository->delete($id);
    }

    public function create( $data): mixed
    {
        return $this->usageTypeRepository->create( $data);
    }

    public function find(int|string $id): mixed
    {
        return $this->usageTypeRepository->find($id);
    }


    public function index(): mixed
    {
        return $this->usageTypeRepository->index();

    }
}
