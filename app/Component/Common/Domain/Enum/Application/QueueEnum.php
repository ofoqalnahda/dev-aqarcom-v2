<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Enum\Application;

enum QueueEnum: string
{
    use StandardEnum;

    case DEFAULT = 'default';
    case OTP = 'otp';
    case SMS = 'sms';
    case MAIL = 'mail';
    case PUSH = 'push';
    case TWILIO_OTP = 'twilio_otp';
    case UNIFONIC_OTP = 'unifonic_otp';
}
