<?php

namespace App\Component\Settings\Application\Mapper;

use App\Component\Settings\Data\Entity\WithdrawalRequest;
use App\Component\Settings\Presentation\ViewModel\WithdrawalViewModel;

interface WithdrawalMapperInterface
{
    public function toViewModel(WithdrawalRequest $withdrawalRequest): WithdrawalViewModel;
    
    public function toViewModelCollection(array $withdrawalRequests): array;
} 