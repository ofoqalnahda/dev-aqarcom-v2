<?php

namespace App\Component\Settings\Application\Repository;

use App\Component\Settings\Data\Entity\WithdrawalRequest;

interface WithdrawalRepositoryInterface
{
    public function create(array $data): WithdrawalRequest;
    
    public function findById(int $id): ?WithdrawalRequest;
    
    public function findByUserId(int $userId): array;
    
    public function update(WithdrawalRequest $withdrawalRequest, array $data): WithdrawalRequest;
    
    public function delete(WithdrawalRequest $withdrawalRequest): bool;
} 