<?php

namespace App\Component\Ad\Presentation\ViewQuery;

interface AdViewQueryInterface
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
    public function find(int|string $id): mixed;


}
