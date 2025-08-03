<?php

namespace App\Component\Settings\Application\Service;

use App\Component\Settings\Data\Entity\Package;

interface PackageServiceInterface
{
    public function getPackagesByType(string $type): array;
    
    public function getAllPackages(): array;
    
    public function getActivePackages(?string $type = null): array;
    
    public function getPackage(int $id): ?Package;
} 