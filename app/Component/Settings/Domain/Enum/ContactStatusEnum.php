<?php

namespace App\Component\Settings\Domain\Enum;

enum ContactStatusEnum: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';
} 