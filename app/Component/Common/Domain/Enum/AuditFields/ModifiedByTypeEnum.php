<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Enum\AuditFields;

use App\Component\Common\Domain\Enum\Application\StandardEnum;

/**
 * @description: Used for audit fields:
 *  - created_by_type
 *  - updated_by_type
 *  - deleted_by_type
 * in conjunction with the corresponding *_by_uuid fields, as in a polymorphic relationship.
 */
enum ModifiedByTypeEnum: string
{
    use StandardEnum;

    case USER = 'user';
    case API  = 'api';
}
