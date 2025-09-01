<?php

namespace App\Component\Notification\Application\Mapper;

interface NotificationMapperInterface
{
    /**
     * Map a Notification model to a ViewModel.
     * @param mixed $notification
     * @return mixed
     */
    public function toViewModel($notification);

    /**
     * Map a collection of notifications to ViewModels.
     * @param array $notifications
     * @return array
     */
    public function toViewModels(array $notifications): array;
}
