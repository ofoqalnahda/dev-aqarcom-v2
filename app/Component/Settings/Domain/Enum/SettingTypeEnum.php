<?php

namespace App\Component\Settings\Domain\Enum;

enum SettingTypeEnum: string
{
    case GENERAL = 'general';
    case NOTIFICATION = 'notification';
    case PRIVACY = 'privacy';
    case SECURITY = 'security';
} 