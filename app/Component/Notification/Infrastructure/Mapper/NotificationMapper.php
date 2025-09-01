<?php

namespace App\Component\Notification\Infrastructure\Mapper;

use App\Component\Notification\Application\Mapper\NotificationMapperInterface;
use App\Component\Notification\Presentation\ViewModel\NotificationViewModel;
class NotificationMapper implements NotificationMapperInterface
{
    public function toViewModel($notification): NotificationViewModel
    {
        return new NotificationViewModel($notification);
    }

    public function toViewModels(array $notifications): array
    {
        return array_map(function ($notification) {
            return $this->toViewModel($notification);
        }, $notifications);
    }
}
