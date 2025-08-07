<?php

namespace App\Component\Settings\Application\Repository;

use App\Component\Settings\Data\Entity\ProfitSubscriber;
use Illuminate\Database\Eloquent\Collection;

interface ProfitSubscriberRepositoryInterface
{
    public function findAll(?string $search = null): Collection;
    
    public function findById(int $id): ?ProfitSubscriber;
    
    public function create(array $data): ProfitSubscriber;
    
    public function update(ProfitSubscriber $subscriber, array $data): ProfitSubscriber;
    
    public function delete(ProfitSubscriber $subscriber): bool;
} 