<?php

namespace App\Component\Settings\Infrastructure\Repository;

use App\Component\Settings\Application\Repository\ProfitSubscriberRepositoryInterface;
use App\Component\Settings\Data\Entity\ProfitSubscriber;
use Illuminate\Database\Eloquent\Collection;

class ProfitSubscriberRepositoryEloquent implements ProfitSubscriberRepositoryInterface
{
    public function findAll(?string $search = null): Collection
    {
        $query = ProfitSubscriber::query();
        
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
        }
        
        return $query->orderBy('created_at', 'desc')
                    ->get();
    }
    
    public function findById(int $id): ?ProfitSubscriber
    {
        return ProfitSubscriber::find($id);
    }
    
    public function create(array $data): ProfitSubscriber
    {
        return ProfitSubscriber::create($data);
    }
    
    public function update(ProfitSubscriber $subscriber, array $data): ProfitSubscriber
    {
        $subscriber->update($data);
        return $subscriber->fresh();
    }
    
    public function delete(ProfitSubscriber $subscriber): bool
    {
        return $subscriber->delete();
    }
} 