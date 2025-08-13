<?php

namespace App\Component\Auth\Infrastructure\Repository;

use App\Component\Auth\Application\Repository\RatingRepositoryInterface;
use App\Component\Auth\Data\Entity\Rating;

class RatingRepository implements RatingRepositoryInterface
{
    public function create(array $data): Rating
    {
        return Rating::create($data);
    }
    
    public function update(int $id, array $data): bool
    {
        $rating = Rating::find($id);
        if (!$rating) {
            return false;
        }
        
        return $rating->update($data);
    }
    
    public function delete(int $id): bool
    {
        $rating = Rating::find($id);
        if (!$rating) {
            return false;
        }
        
        return $rating->delete();
    }
}
