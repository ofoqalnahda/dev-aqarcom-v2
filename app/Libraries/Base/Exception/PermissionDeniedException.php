<?php

/**
 * Created by PhpStorm.
 * User: wojciechluczka
 * Date: 07.02.2018
 * Time: 13:51
 */

namespace App\Libraries\Base\Exception;

use Exception;
use Throwable;

class PermissionDeniedException extends Exception
{
    public function __construct(
        string $message = "",
        protected string $guard = "backend",
        int $code = 0,
        ?Throwable $previous = null,
    )
    {
        $message = $message ?: "You don't have access to this resource";
        parent::__construct($message, $code != 0 ? $code : 403, $previous);
    }

    public function getGuard(): string
    {
        return $this->guard;
    }
}
