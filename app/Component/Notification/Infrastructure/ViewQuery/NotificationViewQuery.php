<?php

namespace App\Component\Notification\Infrastructure\ViewQuery;

use App\Component\Notification\Presentation\ViewQuery\NotificationViewQueryInterface;
use App\Component\Notification\Data\Entity\Notification\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationViewQuery implements NotificationViewQueryInterface
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

    public function find(int|string $id): mixed
    {
        return Notification::find($id);
    }
}
