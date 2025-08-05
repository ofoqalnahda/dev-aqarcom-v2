<?php

namespace App\Component\Payments\Domain\Enum;

enum SubscriptionStatus: string
{
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case CANCELLED = 'cancelled';
    case SUSPENDED = 'suspended';
} 