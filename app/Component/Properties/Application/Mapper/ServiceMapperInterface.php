<?php

namespace App\Component\Properties\Application\Mapper;

use App\Component\Properties\Presentation\ViewModel\ServiceViewModel;

interface ServiceMapperInterface
{
    /**
     * Map a Service model to a ServiceViewModel.
     * @param mixed $service
     * @return ServiceViewModel
     */
    public function toViewModel(mixed $service): ServiceViewModel;
}
