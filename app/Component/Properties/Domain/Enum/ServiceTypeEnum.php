<?php

namespace App\Component\Properties\Domain\Enum;

enum ServiceTypeEnum: string
{
    case REAL_ESTATE_SERVICES = 'real_estate_services';
    case SUPPORT_SERVICES = 'support_services';

    public function label(): string
    {
        return match($this) {
            self::REAL_ESTATE_SERVICES => 'Real Estate Services',
            self::SUPPORT_SERVICES => 'Support Services',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
