<?php

namespace App\Component\Settings\Application\Repository;

use App\Component\Settings\Data\Entity\ProfitSubscriber;

interface ProfitSubscriberRepositoryInterface
{
    public function findAll(?string $search = null): array;
    
    public function findById(int $id): ?ProfitSubscriber;
    
    public function create(array $data): ProfitSubscriber;
    
    public function update(ProfitSubscriber $subscriber, array $data): ProfitSubscriber;
    
    public function delete(ProfitSubscriber $subscriber): bool;
} 