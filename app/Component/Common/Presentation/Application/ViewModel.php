<?php

declare(strict_types = 1);

namespace App\Component\Common\Presentation\Application;

use Illuminate\Contracts\Support\Arrayable;

abstract class ViewModel implements Arrayable
{
    abstract public function toArray(): array;
}
