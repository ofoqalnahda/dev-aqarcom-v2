<?php

namespace App\Component\Settings\Application\Repository;

use App\Component\Settings\Data\Entity\Package;

interface PackageRepositoryInterface
{
    public function findAll(): array;
    
    public function findByType(string $type): array;
    
    public function findActiveByType(string $type): array;
    
    public function findActive(): array;
    
    public function findById(int $id): ?Package;
    
    public function create(array $data): Package;
    
    public function update(Package $package, array $data): Package;
    
    public function delete(Package $package): bool;
} 