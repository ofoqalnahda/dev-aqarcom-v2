<?php

namespace App\Component\Settings\Domain\Enum;

enum WithdrawalStatusEnum: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
} 