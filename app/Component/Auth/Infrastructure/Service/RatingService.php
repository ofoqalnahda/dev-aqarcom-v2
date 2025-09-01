<?php

namespace App\Component\Auth\Infrastructure\Service;

use App\Component\Auth\Application\Service\RatingServiceInterface;
use App\Component\Auth\Application\Repository\RatingRepositoryInterface;
use App\Component\Auth\Infrastructure\ViewQuery\RatingViewQuery;
use App\Component\Auth\Data\Entity\Rating;
use Illuminate\Support\Facades\Auth;

class RatingService implements RatingServiceInterface
{
    public function __construct(
        private RatingRepositoryInterface $ratingRepository,
        private RatingViewQuery $ratingViewQuery
    ) {}

    public function createRating(array $data): Rating
    {
        // Check if user can rate this company
        if (!$this->canUserRate($data['user_id'], $data['company_id'])) {
            throw new \Exception('User cannot rate this company');
        }

        // Check if user already rated this company
        $existingRating = $this->ratingViewQuery->findByUserAndCompany($data['user_id'], $data['company_id']);
        if ($existingRating) {
            throw new \Exception('User has already rated this company');
        }

        return $this->ratingRepository->create($data);
    }
    
    public function updateRating(int $id, array $data): bool
    {
        $rating = $this->ratingViewQuery->findById($id);
        if (!$rating) {
            return false;
        }

        // Only the user who created the rating can update it
        if ($rating->user_id !== Auth::id()) {
            throw new \Exception('Unauthorized to update this rating');
        }

        return $this->ratingRepository->update($id, $data);
    }
    
    public function deleteRating(int $id): bool
    {
        $rating = $this->ratingViewQuery->findById($id);
        if (!$rating) {
            return false;
        }

        // Only the user who created the rating can delete it
        if ($rating->user_id !== Auth::id()) {
            throw new \Exception('Unauthorized to delete this rating');
        }

        return $this->ratingRepository->delete($id);
    }
    
    public function canUserRate(int $userId, int $companyId): bool
    {
        // User cannot rate themselves
        if ($userId === $companyId) {
            return false;
        }

        // Check if company exists and is active
        $company = \App\Models\User::find($companyId);
        if (!$company || !$company->is_active ?? true) {
            return false;
        }

        return true;
    }
}



