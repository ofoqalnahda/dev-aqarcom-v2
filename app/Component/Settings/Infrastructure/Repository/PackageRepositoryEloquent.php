<?php

namespace App\Component\Settings\Infrastructure\Repository;

use App\Component\Settings\Application\Repository\PackageRepositoryInterface;
use App\Component\Settings\Data\Entity\Package;

class PackageRepositoryEloquent implements PackageRepositoryInterface
{
    public function findAll(): array
    {
        return Package::orderBy('sort_order')
                     ->orderBy('period_months')
                     ->get()
                     ->toArray();
    }

    public function findByType(string $type): array
    {
        return Package::where('type', $type)
                     ->orderBy('sort_order')
                     ->orderBy('period_months')
                     ->get()
                     ->toArray();
    }

    public function findActiveByType(string $type): array
    {
        return Package::where('type', $type)
                     ->where('is_active', true)
                     ->orderBy('sort_order')
                     ->orderBy('period_months')
                     ->get()
                     ->toArray();
    }

    public function findActive(): array
    {
        return Package::where('is_active', true)
                     ->orderBy('type')
                     ->orderBy('sort_order')
                     ->orderBy('period_months')
                     ->get()
                     ->toArray();
    }

    public function findById(int $id): ?Package
    {
        return Package::find($id);
    }

    public function create(array $data): Package
    {
        return Package::create($data);
    }

    public function update(Package $package, array $data): Package
    {
        $package->update($data);
        return $package->fresh();
    }

    public function delete(Package $package): bool
    {
        return $package->delete();
    }
}
