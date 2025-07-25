<?php

namespace App\Component\Settings\Infrastructure\Service;

use App\Component\Settings\Application\Service\PackageServiceInterface;
use App\Component\Settings\Application\Repository\PackageRepositoryInterface;
use App\Component\Settings\Data\Entity\Package;

class PackageService implements PackageServiceInterface
{
    protected PackageRepositoryInterface $packageRepository;

    public function __construct(PackageRepositoryInterface $packageRepository)
    {
        $this->packageRepository = $packageRepository;
    }

    public function getPackagesByType(string $type): array
    {
        return $this->packageRepository->findActiveByType($type);
    }
    
    public function getAllPackages(): array
    {
        return $this->packageRepository->findActive();
    }
    
    public function getActivePackages(?string $type = null): array
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