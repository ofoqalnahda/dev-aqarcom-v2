<?php

namespace App\Component\Settings\Application\Mapper;

use App\Component\Settings\Data\Entity\Package;
use App\Component\Settings\Presentation\ViewModel\PackageViewModel;

interface PackageMapperInterface
{
    public function toViewModel(Package $package): PackageViewModel;
    
    public function toViewModelCollection(array $packages): array;
} 