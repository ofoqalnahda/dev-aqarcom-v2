<?php

namespace App\Component\Settings\Infrastructure\Mapper;

use App\Component\Settings\Application\Mapper\WithdrawalMapperInterface;
use App\Component\Settings\Data\Entity\WithdrawalRequest;
use App\Component\Settings\Presentation\ViewModel\WithdrawalViewModel;
use Illuminate\Database\Eloquent\Collection;

class WithdrawalMapper implements WithdrawalMapperInterface
{
    public function toViewModel(WithdrawalRequest $withdrawalRequest): WithdrawalViewModel
    {
        return new WithdrawalViewModel($withdrawalRequest);
    }
    
    public function toViewModelCollection(Collection $withdrawalRequests): array
    {
        return array_map(function ($withdrawalRequest) {
            return $this->toViewModel($withdrawalRequest);
        }, $withdrawalRequests->all());
    }
} 