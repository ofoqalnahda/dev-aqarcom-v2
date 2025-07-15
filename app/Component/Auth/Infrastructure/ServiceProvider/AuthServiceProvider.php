<?php

namespace App\Component\Auth\Infrastructure\ServiceProvider;

use App\Component\Auth\Infrastructure\ViewQuery\UserViewQuery;
use App\Component\Auth\Presentation\ViewQuery\UserViewQueryInterface;
use App\Component\Common\Infrastructure\ServiceProvider\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();
    }

    public function boot(): void
    {

    }

    protected function regularBindings(): array
    {
        return [
            \App\Component\Auth\Presentation\ViewQuery\UserViewQueryInterface::class => \App\Component\Auth\Infrastructure\ViewQuery\UserViewQuery::class,
            \App\Component\Auth\Application\Repository\UserRepository::class => \App\Component\Auth\Infrastructure\Repository\UserRepositoryEloquent::class,
            \App\Component\Auth\Application\Service\UserServiceInterface::class => \App\Component\Auth\Infrastructure\Service\UserService::class,
            \App\Component\Auth\Application\Mapper\UserMapperInterface::class => \App\Component\Auth\Infrastructure\Mapper\UserMapper::class,
        ];
    }

}
