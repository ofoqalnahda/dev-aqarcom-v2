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
    public function find($id): ?\App\Models\User;

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

    /**
     * Get a paginated list of service providers with optional distance calculation.
     * @param array $filters
     * @param int $perPage
     * @param float|null $userLat
     * @param float|null $userLng
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listServiceProviders(array $filters = [], int $perPage = 15, ?float $userLat = null, ?float $userLng = null);

    /**
     * Find a service provider by ID with optional distance calculation.
     * @param int $id
     * @param float|null $userLat
     * @param float|null $userLng
     * @return \App\Models\User|null
     */
    public function findServiceProvider(int $id, ?float $userLat = null, ?float $userLng = null);
}
