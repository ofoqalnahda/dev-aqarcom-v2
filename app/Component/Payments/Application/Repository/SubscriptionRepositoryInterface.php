<?php

namespace App\Component\Payments\Application\Repository;

use App\Component\Payments\Domain\Entity\Subscription;

interface SubscriptionRepositoryInterface
{
    public function findById(int $id): ?Subscription;
    
    public function findByUserId(int $userId): \Illuminate\Database\Eloquent\Collection;
    
    public function findActiveByUserId(int $userId): \Illuminate\Database\Eloquent\Collection;
    
    public function create(array $data): Subscription;
    
    public function update(Subscription $subscription, array $data): Subscription;
    
    public function delete(Subscription $subscription): bool;
} 