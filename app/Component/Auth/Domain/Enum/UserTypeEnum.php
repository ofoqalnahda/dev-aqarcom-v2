<?php

namespace App\Component\Auth\Domain\Enum;

use App\Component\Common\Domain\Enum\Application\StandardEnum;

enum UserTypeEnum: string
{
    use StandardEnum;

    CASE INDIVIDUAL = 'individual';
    case OFFICE = 'office';
    case ORGANIZATION = 'organization';

    case SUPPORT_FACILITY = 'support_facility';

}
