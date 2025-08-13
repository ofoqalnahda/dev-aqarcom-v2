<?php

namespace App\Component\Auth\Application\Repository;

use App\Component\Auth\Data\Entity\Rating;

interface RatingRepositoryInterface
{
    public function create(array $data): Rating;
    
    public function update(int $id, array $data): bool;
    
    public function delete(int $id): bool;
}
