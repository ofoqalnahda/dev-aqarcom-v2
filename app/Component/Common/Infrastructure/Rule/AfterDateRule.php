<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Rule;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Throwable;

class AfterDateRule implements ValidationRule
{

    public function __construct(private readonly Carbon $date)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $date = Carbon::parse($value);
        } catch (Throwable) {
            $fail('Value must be a date.');

            return;
        }

        if ($date->lessThanOrEqualTo($this->date)) {
            $fail('Value must be after date.');
        }
    }
}
