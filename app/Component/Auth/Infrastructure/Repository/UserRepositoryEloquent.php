<?php

namespace App\Component\Auth\Infrastructure\Repository;

use App\Component\Auth\Application\Repository\UserRepository;
use App\Models\User;

class UserRepositoryEloquent implements UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }

    public function delete($id): bool
    {
        $user = User::find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }


}
