<?php

namespace App\Component\Settings\Infrastructure\Repository;

use App\Component\Settings\Application\Repository\WithdrawalRepositoryInterface;
use App\Component\Settings\Data\Entity\WithdrawalRequest;
use Illuminate\Database\Eloquent\Collection;

class WithdrawalRepositoryEloquent implements WithdrawalRepositoryInterface
{
    public function create(array $data): WithdrawalRequest
    {
        return WithdrawalRequest::create($data);
    }
    
    public function findById(int $id): ?WithdrawalRequest
    {
        return WithdrawalRequest::find($id);
    }
    
    public function findByUserId(int $userId): Collection
    {
        return WithdrawalRequest::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    public function update(WithdrawalRequest $withdrawalRequest, array $data): WithdrawalRequest
    {
        $withdrawalRequest->update($data);
        return $withdrawalRequest->fresh();
    }
    
    public function delete(WithdrawalRequest $withdrawalRequest): bool
    {
        return $withdrawalRequest->delete();
    }
} 