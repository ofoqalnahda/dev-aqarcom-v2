<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Repository\Translation;

use Illuminate\Cache\RedisStore;

class TranslationRedisStore extends RedisStore
{
    protected function serialize($value)
    {
        if (is_string($value) && json_validate($value)) {
            return $value;
        }

        if (is_array($value)) {
            return json_encode($value);
        }

        return json_encode($value, JSON_THROW_ON_ERROR);
    }

    protected function unserialize($value)
    {
        return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
    }
}
