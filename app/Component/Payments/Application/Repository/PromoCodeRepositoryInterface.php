<?php

namespace App\Component\Payments\Application\Repository;

use App\Component\Payments\Domain\Entity\PromoCode;

interface PromoCodeRepositoryInterface
{
    public function findById(int $id): ?PromoCode;
    
    public function findByCode(string $code): ?PromoCode;
    
    public function findActiveByCode(string $code): ?PromoCode;
    
    public function incrementUsageCount(PromoCode $promoCode): void;
    
    public function create(array $data): PromoCode;
    
    public function update(PromoCode $promoCode, array $data): PromoCode;
    
    public function delete(PromoCode $promoCode): bool;
} 