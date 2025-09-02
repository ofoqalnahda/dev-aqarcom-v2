<?php

namespace App\Component\Notification\Presentation\ViewQuery;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;

interface NotificationViewQueryInterface
{
    /**
     * Get paginated notifications for a user with optional filters.
     * @param Authenticatable $user
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function list(Authenticatable $user, array $filters = []): LengthAwarePaginator;

    /**
     * Find a notification by ID.
     * @param int|string $id
     * @return mixed
     */
    public function find(int|string $id): mixed;
}
