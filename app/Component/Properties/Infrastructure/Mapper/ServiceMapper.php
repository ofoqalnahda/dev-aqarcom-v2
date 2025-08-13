<?php

namespace App\Component\Properties\Infrastructure\Mapper;

use App\Component\Properties\Application\Mapper\ServiceMapperInterface;
use App\Component\Properties\Presentation\ViewModel\ServiceViewModel;

class ServiceMapper implements ServiceMapperInterface
{
    public function toViewModel(mixed $service): ServiceViewModel
    {
        return new ServiceViewModel($service);
    }
}
