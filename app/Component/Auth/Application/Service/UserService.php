<?php

namespace App\Component\Auth\Application\Service;

interface UserService
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
     * Fetch a user by ID.
     * @param int|string $id
     * @return mixed
     */
    public function find($id);
} 