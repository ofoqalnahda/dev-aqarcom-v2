<?php

namespace App\Component\Auth\Infrastructure\ViewQuery;

use App\Component\Auth\Presentation\ViewQuery\UserViewQueryInterface;
use App\Models\User;

class UserViewQuery implements UserViewQueryInterface
{
    public function list(array $filters = []): array
    {
        $query = User::query();
        // Apply filters if needed
        foreach ($filters as $key => $value) {
            $query->where($key, $value);
        }
        return $query->get()->toArray();
    }

    public function find($id): ?User
    {
        return User::query()->findOrFail($id);
    }

    public function findUserByPhone(string $phone)
    {
        return User::query()->where('phone','=', $phone)->first();
    }

    public function findUserByCode(string $code)
    {
        return User::query()::where('code','=', $code)->first();
    }
}
