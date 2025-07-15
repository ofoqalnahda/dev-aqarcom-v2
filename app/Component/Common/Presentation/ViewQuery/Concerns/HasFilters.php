<?php

declare(strict_types = 1);

namespace App\Component\Common\Presentation\ViewQuery\Concerns;

use App\Component\Account\DomainModel\Auth\AuthService;
use App\Component\Account\DomainModel\Auth\Enum\RoleEnum;
use App\Component\Ownership\Application\Service\OwnershipIdentifierService;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait HasFilters
{
    abstract public function authService(): AuthService;

    abstract public function ownershipIdService(): OwnershipIdentifierService;

    private function applyInCompanyUuidsFilter(
        Collection $uuids,
        Builder $query,
        string $column = 'company_uuid',
    ): self
    {
        if ($this->authService()->hasAnyRole([RoleEnum::CORPORATE_COORDINATOR()])) {
            $companyUuids = $this->ownershipIdService()->getRealCompanyUuids($uuids, trustGuest: false) ?? collect();

            return $this->applyWhereInFilter($companyUuids , $query, $column);
        }

        if ($this->authService()->hasAnyRole(RoleEnum::adminRoles()) && $uuids->isNotEmpty()) {
            return $this->applyWhereInFilter($uuids , $query, $column);
        }

        return $this;
    }

    private function applyInOfficeUuidsFilter(
        Collection $uuids,
        Builder $query,
        string $column = 'office_uuid',
    ): self
    {
        $officeUuids = $this->ownershipIdService()->getRealOfficeUuids($uuids, trustGuest: false) ?? collect();
        $requiredByRole = $this->authService()->hasAnyRole(RoleEnum::managerRoles());

        if ($requiredByRole) {
            return $this->applyWhereInFilter($officeUuids, $query, $column);
        }

        return $this;
    }

    private function applyUserUuidFilter(Builder $query, string $column = 'user_uuid'): self
    {
        $requiredByRole = $this->authService()->hasAnyRole([RoleEnum::CUSTOMER()]);

        if ($requiredByRole) {
            $query->where($column, '=', $this->authService()->user()->uuid());
        }

        return $this;
    }

    public function applyDateRange(
        ?CarbonPeriod $period,
        Builder $query,
        string $column,
    ): self
    {
        return tap($this, static fn () => $query->when(
            $period,
            static fn (Builder $query) => $query->whereBetween($column, [$period->start->startOfDay(), $period->end->endOfDay()]),
        ));
    }

    private function applyWhereInFilter(
        Collection $uuids,
        Builder $query,
        string $column,
    ): self
    {
        return tap($this, static fn () => $query->whereIn($column, $uuids));
    }
}
