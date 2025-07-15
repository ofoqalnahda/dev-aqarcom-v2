<?php

declare(strict_types = 1);

namespace App\Libraries\DataTables\Traits;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Throwable;

trait HasDateFilterDataTableTrait
{
    /** @param string|Carbon|null $candidate */
    private function createDateFromCandidate($candidate): ?CarbonInterface
    {
        try {
            return Carbon::parse($candidate);
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @param string $table
     * @param string $column
     * @param mixed|Builder $query
     * @param mixed|string $keywords
     * @param string $keywordColumn
     * @param string $relationName
     */
    private function filterByDate(
        string $table,
        string $column,
        $query,
        $keywords,
        string $keywordColumn = '',
        string $relationName = '',
    ): void
    {
        $keywordColumn = $keywordColumn ?: $column;
        $canCheckColumnKeyword = method_exists($this, 'columnHasKeyword');
        $missingKeyword = $canCheckColumnKeyword && ! $this->columnHasKeyword($keywordColumn);
        $dates = $this->parseDatesCandidates($keywords);

        if ($missingKeyword || ! $this->hasDatesToFilter($dates)) {
            return;
        }

        $queryColumn = sprintf('%s.%s', $table, $column);
        $fromDate = $this->parseDateFromCandidates($dates, 0);
        $untilDate = $this->parseDateFromCandidates($dates, 1);

        match ($relationName !== '') {
            true => $query->whereHas($relationName, static fn ($query) => $query
                    ->when($fromDate instanceof Carbon, static fn ($query) => $query->whereDate($queryColumn, '>=', $fromDate))
                    ->when($untilDate instanceof Carbon, static fn ($query) => $query->whereDate($queryColumn, '<=', $untilDate))
            ),
            default => $query
                ->when($fromDate instanceof Carbon, static fn ($query) => $query->whereDate($queryColumn, '>=', $fromDate))
                ->when($untilDate instanceof Carbon, static fn ($query) => $query->whereDate($queryColumn, '<=', $untilDate)),
        };
    }

    private function hasDatesToFilter(array $dates): bool
    {
        return collect($dates)->filter()->isNotEmpty();
    }

    private function isValidDateCandidate(?string $date = null): bool
    {
        return (bool) strtotime((string) $date);
    }

    /** @return mixed[] */
    private function parseDatesCandidates(string $candidates): array
    {
        $dates = json_decode($candidates);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        if (! is_array($dates)) {
            return [];
        }

        return array_values($dates);
    }

    private function parseDateFromCandidates(
        array $candidates,
        int $candidateIndex,
    ): ?CarbonInterface
    {
        $dateCandidate = Arr::get($candidates, $candidateIndex);
        $date = null;

        if ($this->isValidDateCandidate($dateCandidate)) {
            $date = $this->createDateFromCandidate($dateCandidate);
        }

        return $date;
    }
}
