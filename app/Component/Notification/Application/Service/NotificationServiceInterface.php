<?php

namespace App\Component\Notification\Application\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;

interface NotificationServiceInterface
{
    /**
     * Get paginated notifications for a user.
     * @param Authenticatable $user
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function list(Authenticatable $user, array $filters = []): LengthAwarePaginator;

    /**
     * Mark a notification as read.
     * @param int|string $id
     * @param Authenticatable $user
     * @return bool
     */
    public function markAsRead(int|string $id, Authenticatable $user): bool;

    /**
     * Mark all notifications as read for a user.
     * @param Authenticatable $user
     * @return int
     */
    public function markAllAsRead(Authenticatable $user): int;

    /**
     * Create a new notification.
     * @param int $userId
     * @param string $message
     * @return mixed
     */
    public function create(int $userId, string $message);

    /**
     * Get unread count for a user.
     * @param Authenticatable $user
     * @return int
     */
    public function getUnreadCount(Authenticatable $user): int;
}
