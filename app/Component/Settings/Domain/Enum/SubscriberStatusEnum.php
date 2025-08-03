<?php

namespace App\Component\Settings\Domain\Enum;

enum SubscriberStatusEnum: string
{
    case INDEPENDENT = 'independent';
    case NOT_INDEPENDENT = 'not_independent';
} 