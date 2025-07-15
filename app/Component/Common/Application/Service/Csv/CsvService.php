<?php

declare(strict_types = 1);

namespace App\Component\Common\Application\Service\Csv;

interface CsvService
{
    public function toCsv(array $array): string;

    public function toArray(string $csv): array;
}
