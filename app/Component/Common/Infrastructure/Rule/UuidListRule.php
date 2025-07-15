<?php

declare(strict_types=1);

namespace App\Component\Common\Infrastructure\Rule;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class UuidListRule implements ValidationRule
{
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail,
    ): void
    {
        if (!is_string($value) && !is_array($value)) {
            $fail('Value must be a string or an array.');
        }

        $list = [];
        if (is_string($value)) {
            if (str_contains($value, ',')) {
                $list = explode(',', $value);
            }

            if (str_contains($value, ' ')) {
                $list = explode(' ', $value);
            }

            if (! Str::of($value)->isUuid() && empty($list)) {
                $fail('Given string should be a valid UUID or coma|space separated list.');
            }
        } else {
            $list = $value;
        }

        $failed = [];
        foreach ($list as $item) {
            if (! Str::of($item)->isUuid()) {
                $failed[] = $item;
            }
        }

        $message = [];
        if (! empty($failed)) {
            foreach ($failed as $item) {
                $message[] = $item . ' is not a valid UUID';
            }

            $message = implode(', ', $message);
            $fail($message);
        }
    }
}
