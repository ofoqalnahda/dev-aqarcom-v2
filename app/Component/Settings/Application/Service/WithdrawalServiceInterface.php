<?php

namespace App\Component\Settings\Application\Service;

use App\Component\Settings\Data\Entity\WithdrawalRequest;

interface WithdrawalServiceInterface
{
    public function createWithdrawalRequest(int $userId, array $data): WithdrawalRequest;
    
    public function getUserWithdrawalRequests(int $userId): array;
    
    public function updateWithdrawalStatus(int $requestId, string $status, ?string $rejectionReason = null): WithdrawalRequest;
    
    public function getWithdrawalRequest(int $requestId): ?WithdrawalRequest;
} 