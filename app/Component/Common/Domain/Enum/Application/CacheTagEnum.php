<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Enum\Application;

enum CacheTagEnum: string
{
    case SYSTEM_CLIENT = 'system_client';
    case USER_LOGGED_IN_COMPANY_UUID = 'user_%s_login_company_uuid';
    case CUSTOMER_SUMMARY = 'customer_%s';
}
