<?php

namespace App\Component\Auth\Infrastructure\Service;

use App\Component\Auth\Application\Service\UserServiceInterface;
use App\Component\Auth\Application\Repository\UserRepository;
use App\Component\Auth\Domain\Enum\UserTypeEnum;
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

        //set random code
        $user->update([
            'code' => app()->isProduction() ? rand(1000, 9999): 1111,
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

    public function verifyCode(int $user_id, string $code):object|null
    {
        $user = $this->userViewQuery->find($user_id);

        if ($user->code === $code) {
            $user->update(['code' => null]);
            return $user;
        }
        return null;
    }

    public function completeProfile($user, array $data)
    {
        // Only update allowed fields
        $data['user_type'] = $data['account_type'] ?? UserTypeEnum::INDIVIDUAL->value; // Map account_type to user_type
        unset($data['account_type']); // account_type is not used here

        $fields = [
            'name',
            'identity_number',
            'email',
            'user_type',
            'commercial_name',
            'commercial_number',
        ];
        $updateData = array_intersect_key($data, array_flip($fields));
        $this->userRepository->update($user->id, $updateData);
        $user->refresh();
        return $user;
    }

    public function editProfile($user, array $data)
    {
        $fields = [
            'name',
            'email',
            'whatsapp',
            'commercial_name',
            'latitude',
            'longitude',
            'address',
            'about_company',
        ];
        $updateData = array_intersect_key($data, array_flip($fields));

        // Handle location array if present
        if (isset($data['location'])) {
            foreach (['latitude', 'longitude', 'address'] as $locField) {
                if (isset($data['location'][$locField])) {
                    $updateData[$locField] = $data['location'][$locField];
                }
            }
        }

        // Update user basic info
        $this->userRepository->update($user->id, $updateData);

        // Handle working hours
        if (isset($data['working_hours'])) {
            $this->updateWorkingHours($user, $data['working_hours']);
        }

        // Handle previous work history
        if (isset($data['previous_work_history'])) {
            $this->updatePreviousWorkHistory($user, $data['previous_work_history']);
        }

        // Handle services
        if (isset($data['services'])) {
            $this->updateServices($user, $data['services']);
        }

        $user->refresh();
        return $user;
    }

    public function resendCode(int $user_id): bool
    {
        $user = $this->userViewQuery->find($user_id);
        if (!$user) {
            return false;
        }
        $newCode = app()->isProduction() ? rand(1000, 9999) : 1111;
        $user->update(['code' => $newCode]);
        // This would typically call a notification service

        return true;
    }

    public function logout($user): bool
    {
        // Revoke all tokens for the current user
        $user->tokens()->delete();

        return true;
    }

    private function updateWorkingHours($user, array $workingHours): void
    {
        // Delete existing working hours
        $user->workingHours()->delete();

        // Create new working hours
        foreach ($workingHours as $wh) {
            $user->workingHours()->create([
                'day' => $wh['day'],
                'start_time' => $wh['start_time'] ?? null,
                'end_time' => $wh['end_time'] ?? null,
                'is_working_day' => $wh['is_working_day'] ?? true,
            ]);
        }
    }

    private function updatePreviousWorkHistory($user, array $workHistory): void
    {
        // Delete existing work history
        $user->previousWorkHistory()->delete();

        // Create new work history
        foreach ($workHistory as $wh) {
            $user->previousWorkHistory()->create([
                'company_name' => $wh['company_name'],
                'description' => $wh['description'],
                'start_date' => $wh['start_date'] ?? null,
                'end_date' => $wh['is_current_job'] ? null : ($wh['end_date'] ?? null),
                'is_current_job' => $wh['is_current_job'] ?? false,
            ]);
        }
    }

    private function updateServices($user, array $serviceIds): void
    {
        // Sync services (this will handle both attaching and detaching)
        $user->services()->sync($serviceIds);
    }
}
