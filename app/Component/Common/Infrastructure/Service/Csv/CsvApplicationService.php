<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Service\Csv;

use App\Component\Common\Application\Service\Csv\CsvService;

class CsvApplicationService implements CsvService
{
    private const LINE_DELIMITER = PHP_EOL;
    private const FIELD_DELIMITER = ',';
    private const STRING_DELIMITER = '"';

    public function toCsv(array $array): string
    {
        $output = '';

        foreach ($array as $rowKey => $row) {
            if ($rowKey > 0) {
                $output .= self::LINE_DELIMITER;
            }

            foreach ($row as $cellKey => $cell) {
                if ($cellKey > 0) {
                    $output .= self::FIELD_DELIMITER;
                }

                $output .= match(gettype($cell)) {
                    "string"   => strpos($cell, self::FIELD_DELIMITER) !== false
                        ? self::STRING_DELIMITER . $cell . self::STRING_DELIMITER
                        : $cell,
                    "boolean" => $cell ? '1' : '0',
                    default => (string)$cell,
                };
            }
        }

        return $output;
    }

    public function toArray(string $csv): array
    {
        $array = [];
        $rows = explode(self::LINE_DELIMITER, trim($csv));

        foreach ($rows as $row) {
            $cells = explode(self::FIELD_DELIMITER, trim($row));

            $arrayRow = [];

            foreach($cells as $cell) {
                $arrayRow[] = trim($cell, self::STRING_DELIMITER);
            }

            $array[] = $arrayRow;
        }

        return $array;
    }
}
