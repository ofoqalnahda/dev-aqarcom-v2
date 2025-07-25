<?php

namespace App\Component\Auth\Infrastructure\Service;

use App\Component\Auth\Application\Service\UserServiceInterface;
use App\Component\Auth\Application\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Component\Auth\Presentation\ViewQuery\UserViewQueryInterface;
use Illuminate\Support\Str;

class UserService implements UserServiceInterface
{
    protected $userRepository;
    protected $userViewQuery;

    public function __construct(UserRepository $userRepository, UserViewQueryInterface $userViewQuery)
    {
        $this->userRepository = $userRepository;
        $this->userViewQuery = $userViewQuery;
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

    public function authenticate(string $email, string $password)
    {
        $user = $this->userRepository->findByEmail($email);
        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        return null;
    }

    public function loginByPhone(string $phone)
    {
        $user = $this->userViewQuery->findUserByPhone($phone);
        if (!$user) {
            $user = $this->userRepository->create([
                'name' => null,
                'email' => null,
                'phone' => $phone,
                'password' => Hash::make(Str::random(10)),
            ]);
        }

        //set ranom code
        $user->update([
            'code' => rand(1000, 9999),
        ]);
        return $user;
    }

    public function update($id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->userRepository->delete($id);
    }

    public function verifyCode($user, string $code): bool
    {
        if ($user->code === $code) {
            $user->update(['code' => null]);
            return true;
        }
        return false;
    }

    public function completeProfile($user, array $data)
    {
        // Only update allowed fields
        $fields = [
            'name',
            'identity_number',
            'email',
            'account_type',
            'commercial_name',
            'commercial_number',
        ];
        $updateData = array_intersect_key($data, array_flip($fields));
        $this->userRepository->update($user->id, $updateData);
        $user->refresh();
        return $user;
    }
}
