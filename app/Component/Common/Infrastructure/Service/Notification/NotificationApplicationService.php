<?php

declare(strict_types=1);

namespace App\Component\Common\Infrastructure\Service\Notification;

use App\Component\Common\Application\Service\Notification\NotificationService;
use App\Component\Common\Domain\Dto\Notification\UserNotifiableDto;
use App\Component\Common\Infrastructure\Notification\Notification;
use App\Component\Notification\Infrastructure\Job\NotificationQueueJob;
use Illuminate\Bus\Dispatcher;

/** @todo: For notifications we should use ChannelManager, not Dispatcher. */
class NotificationApplicationService implements NotificationService
{
    public function __construct(
        private readonly Dispatcher $dispatcher,
    )
    {
    }

    public function send(
        UserNotifiableDto $notifiable,
        Notification $notification,
    ): void
    {
        $job = new NotificationQueueJob($notifiable, $notification);

        $this->dispatcher->dispatch($job);
    }
}
