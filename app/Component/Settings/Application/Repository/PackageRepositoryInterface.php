<?php

namespace App\Component\Settings\Application\Repository;

use App\Component\Settings\Data\Entity\Package;
use Illuminate\Database\Eloquent\Collection;

interface PackageRepositoryInterface
{
    public function findAll(): Collection;

    public function findByType(string $type): Collection;

    public function findActiveByType(string $type): Collection;

    public function findActive(): Collection;

    public function findById(int $id): ?Package;

    public function create(array $data): Package;

    public function update(Package $package, array $data): Package;

    public function delete(Package $package): bool;
}
