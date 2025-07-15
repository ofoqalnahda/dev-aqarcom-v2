<?php

namespace App\Libraries\Curl\Response;

use Illuminate\Support\Collection;

final class Result
{
    private Collection $info;

    /**
     *
     * @param string $data
     * @param array $info
     */
    public function __construct(
        private string $data,
        array $info,
    )
    {
        $this->info = new Collection($info);
    }

    public function data(): string
    {
        return $this->data;
    }

    public function info(): Collection
    {
        return $this->info;
    }
}
