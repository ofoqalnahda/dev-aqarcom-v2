<?php

namespace App\Component\Settings\Application\Mapper;

use App\Component\Settings\Data\Entity\WithdrawalRequest;
use App\Component\Settings\Presentation\ViewModel\WithdrawalViewModel;
use Illuminate\Database\Eloquent\Collection;

interface WithdrawalMapperInterface
{
    public function toViewModel(WithdrawalRequest $withdrawalRequest): WithdrawalViewModel;
    
    public function toViewModelCollection(Collection $withdrawalRequests): array;
} 