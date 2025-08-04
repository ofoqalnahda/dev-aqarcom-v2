<?php

namespace App\Component\Payments\Application\Service;

use App\Component\Payments\Domain\Dto\PromoCodeCalculationDto;
use App\Component\Payments\Domain\Dto\SubscriptionDto;

interface PaymentServiceInterface
{
    public function calculatePromoCode(int $packageId, string $promoCode): PromoCodeCalculationDto;
    
    public function createSubscription(SubscriptionDto $subscriptionDto): array;
    
    public function processPayment(int $subscriptionId, array $paymentDetails): array;
    
    public function getSubscription(int $subscriptionId): ?array;
    
    public function getUserSubscriptions(int $userId): \Illuminate\Database\Eloquent\Collection;
    
    public function getPromoCodeByCode(string $code): ?array;
} 