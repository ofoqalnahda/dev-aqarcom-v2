<?php

namespace App\Component\Auth\Application\Service;

interface UserServiceInterface
{
    /**
     * Register a new user.
     * @param array $data
     * @return mixed
     */
    public function register(array $data);

    /**
     * Authenticate a user (login).
     * @param string $email
     * @param string $password
     * @return mixed
     */
    public function authenticate(string $email, string $password);

    /**
     * Update user information.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Delete a user.
     * @param int|string $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * Login or register user by phone.
     * @param string $phone
     * @return mixed
     */
    public function loginByPhone(string $phone);

    /**
     * Verify the user's code.
     * @param \App\Models\User $user
     * @param string $code
     * @return bool
     */
    public function verifyCode($user, string $code): bool;

    /**
     * Complete the user's profile.
     * @param \App\Models\User $user
     * @param array $data
     * @return \App\Models\User
     */
    public function completeProfile($user, array $data);

    /**
     * Edit the user's profile.
     * @param \App\Models\User $user
     * @param array $data
     * @return \App\Models\User
     */
    public function editProfile($user, array $data);

    /**
     * Resend verification code to user.
     * @param \App\Models\User $user
     * @return string
     */
    public function resendCode($user): string;

    /**
     * Logout user by revoking all tokens.
     * @param \App\Models\User $user
     * @return bool
     */
    public function logout($user): bool;
}
