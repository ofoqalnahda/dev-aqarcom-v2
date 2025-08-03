<?php

namespace App\Component\Auth\Infrastructure\Mapper;

use App\Component\Auth\Application\Mapper\UserMapperInterface;
use App\Component\Auth\Presentation\ViewModel\UserViewModel;

class UserMapper implements UserMapperInterface
{
    public function toViewModel($user): UserViewModel
    {
        return new UserViewModel($user);
    }
}
