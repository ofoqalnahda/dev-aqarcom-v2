<?php

namespace App\Component\Auth\Infrastructure\ViewQuery;

use App\Component\Auth\Data\Entity\Rating;
use Illuminate\Pagination\LengthAwarePaginator;

class RatingViewQuery
{
    public function findById(int $id): ?Rating
    {
        return Rating::find($id);
    }
    
    public function findByUserAndCompany(int $userId, int $companyId): ?Rating
    {
        return Rating::where('user_id', $userId)
            ->where('company_id', $companyId)
            ->first();
    }
    
    public function getCompanyRatings(int $companyId, int $perPage = 15): LengthAwarePaginator
    {
        return Rating::where('company_id', $companyId)
            ->with(['user:id,name,email'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    
    public function getUserRatings(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Rating::where('user_id', $userId)
            ->with(['company:id,name,email'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    
    public function getCompanyAverageRating(int $companyId): float
    {
        return Rating::where('company_id', $companyId)
            ->avg('rating') ?? 0.0;
    }
    
    public function getCompanyRatingCount(int $companyId): int
    {
        return Rating::where('company_id', $companyId)->count();
    }
}



