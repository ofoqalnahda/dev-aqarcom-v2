<?php

namespace App\Component\Auth\Application\Service;

use App\Component\Auth\Data\Entity\Rating;

interface RatingServiceInterface
{
    public function createRating(array $data): Rating;
    
    public function updateRating(int $id, array $data): bool;
    
    public function deleteRating(int $id): bool;
    
    public function canUserRate(int $userId, int $companyId): bool;
}
