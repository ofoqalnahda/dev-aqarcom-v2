<?php

namespace App\Component\Notification\Infrastructure\Service;

use App\Component\Notification\Application\Repository\NotificationRepositoryInterface;
use App\Component\Notification\Application\Service\NotificationServiceInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationService implements NotificationServiceInterface
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    ) {}

    public function list(Authenticatable $user, array $filters = []): LengthAwarePaginator
    {
        return $this->notificationRepository->list($user, $filters);
    }

    public function markAsRead(int|string $id, Authenticatable $user): bool
    {
        return $this->notificationRepository->markAsRead($id, $user);
    }

    public function markAllAsRead(Authenticatable $user): int
    {
        return $this->notificationRepository->markAllAsRead($user);
    }

    public function create(int $userId, string $message)
    {
        return $this->notificationRepository->create([
            'user_id' => $userId,
            'message' => $message,
            'is_read' => false
        ]);
    }

    public function getUnreadCount(Authenticatable $user): int
    {
        return $this->notificationRepository->getUnreadCount($user);
    }
}
