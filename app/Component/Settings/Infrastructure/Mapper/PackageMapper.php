<?php

namespace App\Component\Settings\Infrastructure\Mapper;

use App\Component\Settings\Application\Mapper\PackageMapperInterface;
use App\Component\Settings\Data\Entity\Package;
use App\Component\Settings\Presentation\ViewModel\PackageViewModel;

class PackageMapper implements PackageMapperInterface
{
    public function toViewModel(Package|array $package): PackageViewModel
    {
        return new PackageViewModel($package);
    }

    public function toViewModelCollection(array $packages): array
    {
        return array_map(function ($package) {
            return $this->toViewModel($package);
        }, $packages);
    }
}
