<?php

namespace App\Component\Settings\Infrastructure\Service;

use App\Component\Settings\Application\Service\WithdrawalServiceInterface;
use App\Component\Settings\Application\Repository\WithdrawalRepositoryInterface;
use App\Component\Settings\Data\Entity\WithdrawalRequest;
use Illuminate\Database\Eloquent\Collection;

class WithdrawalService implements WithdrawalServiceInterface
{
    protected WithdrawalRepositoryInterface $withdrawalRepository;

    public function __construct(WithdrawalRepositoryInterface $withdrawalRepository)
    {
        $this->withdrawalRepository = $withdrawalRepository;
    }

    public function createWithdrawalRequest(int $userId, array $data): WithdrawalRequest
    {
        $withdrawalData = array_merge($data, [
            'user_id' => $userId,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        return $this->withdrawalRepository->create($withdrawalData);
    }

    public function getUserWithdrawalRequests(int $userId): Collection
    {
        return $this->withdrawalRepository->findByUserId($userId);
    }

    public function updateWithdrawalStatus(int $requestId, string $status, ?string $rejectionReason = null): WithdrawalRequest
    {
        $withdrawalRequest = $this->withdrawalRepository->findById($requestId);

        if (!$withdrawalRequest) {
            throw new \Exception('Withdrawal request not found');
        }

        $updateData = [
            'status' => $status,
            'processed_at' => now(),
        ];

        if ($rejectionReason) {
            $updateData['rejection_reason'] = $rejectionReason;
        }

        return $this->withdrawalRepository->update($withdrawalRequest, $updateData);
    }

    public function getWithdrawalRequest(int $requestId): ?WithdrawalRequest
    {
        return $this->withdrawalRepository->findById($requestId);
    }
}
