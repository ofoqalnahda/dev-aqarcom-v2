<?php

namespace App\Component\Settings\Infrastructure\Repository;

use App\Component\Settings\Application\Repository\PackageRepositoryInterface;
use App\Component\Settings\Data\Entity\Package;
use Illuminate\Database\Eloquent\Collection;
class PackageRepositoryEloquent implements PackageRepositoryInterface
{
    public function findAll(): Collection
    {
        return Package::orderBy('sort_order')
                     ->orderBy('period_months')
                     ->get();
    }

    public function findByType(string $type): Collection
    {
        return Package::where('type', $type)
                     ->orderBy('sort_order')
                     ->orderBy('period_months')
                     ->get();
    }

    public function findActiveByType(string $type): Collection
    {
        return Package::query()->where('type', $type)
                     ->where('is_active', true)
                     ->orderBy('sort_order')
                     ->orderBy('period_months')
                     ->get();
    }

    public function findActive(): Collection
    {
        return Package::where('is_active', true)
                     ->orderBy('type')
                     ->orderBy('sort_order')
                     ->orderBy('period_months')
                     ->get();
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
