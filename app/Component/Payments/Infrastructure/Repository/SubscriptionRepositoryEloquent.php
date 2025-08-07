<?php

namespace App\Component\Payments\Infrastructure\Repository;

use App\Component\Payments\Application\Repository\SubscriptionRepositoryInterface;
use App\Component\Payments\Domain\Entity\Subscription;

class SubscriptionRepositoryEloquent implements SubscriptionRepositoryInterface
{
    public function findById(int $id): ?Subscription
    {
        return Subscription::with(['user', 'package', 'promoCode'])->find($id);
    }
    
    public function findByUserId(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return Subscription::with(['package', 'promoCode'])
                          ->where('user_id', $userId)
                          ->orderBy('created_at', 'desc')
                          ->get();
    }
    
    public function findActiveByUserId(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return Subscription::with(['package', 'promoCode'])
                          ->where('user_id', $userId)
                          ->where('subscription_status', 'active')
                          ->orderBy('created_at', 'desc')
                          ->get();
    }
    
    public function create(array $data): Subscription
    {
        return Subscription::create($data);
    }
    
    public function update(Subscription $subscription, array $data): Subscription
    {
        $subscription->update($data);
        return $subscription->fresh();
    }
    
    public function delete(Subscription $subscription): bool
    {
        return $subscription->delete();
    }
} 