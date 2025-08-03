<?php

namespace App\Component\Settings\Application\Service;

use App\Component\Settings\Data\Entity\ProfitSubscriber;

interface ProfitSubscriberServiceInterface
{
    public function getAllSubscribers(?string $search = null): array;
    
    public function getSubscriber(int $id): ?ProfitSubscriber;
    
    public function createSubscriber(array $data): ProfitSubscriber;
    
    public function updateSubscriber(int $id, array $data): ProfitSubscriber;
    
    public function deleteSubscriber(int $id): bool;
} 