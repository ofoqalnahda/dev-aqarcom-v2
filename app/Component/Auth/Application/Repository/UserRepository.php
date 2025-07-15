<?php

namespace App\Component\Auth\Application\Repository;

interface UserRepository
{
    /**
     * Create a new user.
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update a user by ID.
     * @param int|string $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Delete a user by ID.
     * @param int|string $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * Find a user by email.
     * @param string $email
     * @return mixed
     */
    public function findByEmail(string $email);
} 