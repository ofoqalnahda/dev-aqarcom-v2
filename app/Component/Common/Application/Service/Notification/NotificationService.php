<?php

declare(strict_types = 1);

namespace App\Component\Common\Application\Service\Notification;

use App\Component\Common\Domain\Dto\Notification\UserNotifiableDto;
use App\Component\Common\Infrastructure\Notification\Notification;

interface NotificationService
{
    public function send(
        UserNotifiableDto $notifiable,
        Notification $notification,
    ): void;
}
