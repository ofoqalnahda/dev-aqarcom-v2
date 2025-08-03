<?php

namespace App\Component\Auth\Application\Mapper;

use App\Component\Auth\Presentation\ViewModel\UserViewModel;

interface UserMapperInterface
{
    /**
     * Map a User model to a UserViewModel.
     * @param mixed $user
     * @return UserViewModel
     */
    public function toViewModel($user): UserViewModel;
}
