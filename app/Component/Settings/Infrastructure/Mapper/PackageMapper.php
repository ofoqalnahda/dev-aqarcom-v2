<?php

namespace App\Component\Settings\Infrastructure\Mapper;

use App\Component\Settings\Application\Mapper\PackageMapperInterface;
use App\Component\Settings\Data\Entity\Package;
use App\Component\Settings\Presentation\ViewModel\PackageViewModel;
use Illuminate\Database\Eloquent\Collection;

class PackageMapper implements PackageMapperInterface
{
    public function toViewModel(Package $package): PackageViewModel
    {
        return new PackageViewModel($package);
    }

    public function toViewModelCollection(Collection $packages): array
    {
        return array_map(
            fn($package) => $this->toViewModel($package),
            $packages->all()
        );
    }
}
