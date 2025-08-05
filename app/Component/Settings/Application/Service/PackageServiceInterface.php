<?php

namespace App\Component\Settings\Application\Service;

use App\Component\Settings\Data\Entity\Package;
use Illuminate\Database\Eloquent\Collection;

interface PackageServiceInterface
{
    public function getPackagesByType(string $type): Collection;

    public function getAllPackages(): Collection;

    public function getActivePackages(?string $type = null): Collection;

    public function getPackage(int $id): ?Package;
}
