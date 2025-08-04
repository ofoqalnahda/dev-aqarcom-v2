<?php

namespace App\Component\Payments\Application\Repository;

use App\Component\Payments\Domain\Entity\Subscription;

interface SubscriptionRepositoryInterface
{
    public function findById(int $id): ?Subscription;
    
    public function findByUserId(int $userId): array;
    
    public function findActiveByUserId(int $userId): array;
    
    public function create(array $data): Subscription;
    
    public function update(Subscription $subscription, array $data): Subscription;
    
    public function delete(Subscription $subscription): bool;
} 