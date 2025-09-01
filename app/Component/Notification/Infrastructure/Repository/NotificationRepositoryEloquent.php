<?php

namespace App\Component\Notification\Infrastructure\Repository;

use App\Component\Notification\Application\Repository\NotificationRepositoryInterface;
use App\Component\Notification\Data\Entity\Notification\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationRepositoryEloquent implements NotificationRepositoryInterface
{
    public function list(Authenticatable $user, array $filters = []): LengthAwarePaginator
    {
        $query = Notification::where('user_id', $user->id);

        // Apply filters
        if (isset($filters['is_read'])) {
            $query->where('is_read', $filters['is_read']);
        }

        if (isset($filters['search'])) {
            $query->where('message', 'like', '%' . $filters['search'] . '%');
        }

        // Default sorting by created_at desc
        $query->orderBy('created_at', 'desc');

        $perPage = $filters['per_page'] ?? 15;
        $page = $filters['page'] ?? 1;

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function find(int|string $id)
    {
        return Notification::find($id);
    }

    public function markAsRead(int|string $id, Authenticatable $user): bool
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$notification) {
            return false;
        }

        $notification->markAsRead();
        return true;
    }

    public function markAllAsRead(Authenticatable $user): int
    {
        return Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
    }

    public function create(array $data)
    {
        return Notification::create($data);
    }

    public function getUnreadCount(Authenticatable $user): int
    {
        return Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();
    }
}
