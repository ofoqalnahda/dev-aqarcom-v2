<?php

namespace App\Component\Auth\Presentation\ViewQuery;

interface UserViewQueryInterface
{
    /**
     * Get a list of users with optional filters.
     * @param array $filters
     * @return array
     */
    public function list(array $filters = []): array;

    /**
     * Find a user by ID.
     * @param int|string $id
     * @return mixed
     */
    public function find($id);

    /**
     * Find a user by phone number.
     * @param string $phone
     * @return mixed
     */
    public function findUserByPhone(string $phone);

    /**
     * Find a user by code.
     * @param string $code
     * @return mixed
     */
    public function findUserByCode(string $code);
}
