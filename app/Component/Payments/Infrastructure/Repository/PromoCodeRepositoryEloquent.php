<?php

namespace App\Component\Payments\Infrastructure\Repository;

use App\Component\Payments\Application\Repository\PromoCodeRepositoryInterface;
use App\Component\Payments\Domain\Entity\PromoCode;

class PromoCodeRepositoryEloquent implements PromoCodeRepositoryInterface
{
    public function findById(int $id): ?PromoCode
    {
        return PromoCode::find($id);
    }
    
    public function findByCode(string $code): ?PromoCode
    {
        return PromoCode::where('code', $code)->first();
    }
    
    public function findActiveByCode(string $code): ?PromoCode
    {
        return PromoCode::where('code', $code)
                       ->where('is_active', true)
                       ->first();
    }
    
    public function incrementUsageCount(PromoCode $promoCode): void
    {
        $promoCode->increment('used_count');
    }
    
    public function create(array $data): PromoCode
    {
        return PromoCode::create($data);
    }
    
    public function update(PromoCode $promoCode, array $data): PromoCode
    {
        $promoCode->update($data);
        return $promoCode->fresh();
    }
    
    public function delete(PromoCode $promoCode): bool
    {
        return $promoCode->delete();
    }
} 