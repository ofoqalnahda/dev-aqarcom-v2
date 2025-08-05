<?php

namespace App\Component\Settings\Infrastructure\Service;

use App\Component\Settings\Application\Service\PackageServiceInterface;
use App\Component\Settings\Application\Repository\PackageRepositoryInterface;
use App\Component\Settings\Data\Entity\Package;
use Illuminate\Database\Eloquent\Collection;

class PackageService implements PackageServiceInterface
{
    protected PackageRepositoryInterface $packageRepository;

    public function __construct(PackageRepositoryInterface $packageRepository)
    {
        $this->packageRepository = $packageRepository;
    }

    public function getPackagesByType(string $type): Collection
    {
        return $this->packageRepository->findActiveByType($type);
    }

    public function getAllPackages(): Collection
    {
        return $this->packageRepository->findActive();
    }

    public function getActivePackages(?string $type = null): Collection
    {
        if ($type) {
            return $this->packageRepository->findActiveByType($type);
        }

        return $this->packageRepository->findActive();
    }

    public function getPackage(int $id): ?Package
    {
        return $this->packageRepository->findById($id);
    }
}
