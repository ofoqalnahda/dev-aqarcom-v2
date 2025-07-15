<?php

declare(strict_types = 1);

namespace App\Component\Common\Domain\Enum\Application;

use BackedEnum;

interface LocalizableEnum extends BackedEnum
{
    public function component(): ComponentEnum;
}
