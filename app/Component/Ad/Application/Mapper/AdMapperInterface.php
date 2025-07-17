<?php

namespace App\Component\Ad\Application\Mapper;

use App\Component\Ad\Presentation\ViewModel\AdViewModel;

interface AdMapperInterface
{
    /**
     * Map a User model to a UserViewModel.
     * @param mixed $user
     * @return AdViewModel
     */
    public function toViewModel($user): AdViewModel;
}
