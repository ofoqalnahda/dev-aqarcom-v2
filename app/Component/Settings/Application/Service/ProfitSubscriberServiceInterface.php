<?php

namespace App\Component\Settings\Application\Service;

use App\Component\Settings\Data\Entity\ProfitSubscriber;
use Illuminate\Database\Eloquent\Collection;

interface ProfitSubscriberServiceInterface
{
    public function getAllSubscribers(?string $search = null): Collection;
    
    public function getSubscriber(int $id): ?ProfitSubscriber;
    
    public function createSubscriber(array $data): ProfitSubscriber;
    
    public function updateSubscriber(int $id, array $data): ProfitSubscriber;
    
    public function deleteSubscriber(int $id): bool;
} 