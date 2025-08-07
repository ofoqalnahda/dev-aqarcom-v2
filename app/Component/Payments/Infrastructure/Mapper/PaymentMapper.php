<?php

namespace App\Component\Payments\Infrastructure\Mapper;

use App\Component\Payments\Application\Mapper\PaymentMapperInterface;
use App\Component\Payments\Domain\Entity\Subscription;
use App\Component\Payments\Domain\Entity\PromoCode;
use App\Component\Payments\Presentation\ViewModel\SubscriptionViewModel;
use App\Component\Payments\Presentation\ViewModel\PromoCodeViewModel;

class PaymentMapper implements PaymentMapperInterface
{
    public function toSubscriptionViewModel(Subscription $subscription): SubscriptionViewModel
    {
        return new SubscriptionViewModel($subscription);
    }
    
    public function toSubscriptionViewModelCollection(\Illuminate\Database\Eloquent\Collection $subscriptions): array
    {
        return array_map(function ($subscription) {
            return $this->toSubscriptionViewModel($subscription);
        }, $subscriptions->all());
    }
    
    public function toPromoCodeViewModel(PromoCode $promoCode): PromoCodeViewModel
    {
        return new PromoCodeViewModel(
            id: $promoCode->id,
            code: $promoCode->code,
            description: $promoCode->description,
            discountType: $promoCode->discount_type,
            discountValue: (float) $promoCode->discount_value,
            minimumAmount: (float) $promoCode->minimum_amount,
            maximumDiscount: (float) $promoCode->maximum_discount,
            usageLimit: $promoCode->usage_limit,
            usedCount: $promoCode->used_count,
            validFrom: $promoCode->valid_from?->toISOString(),
            validUntil: $promoCode->valid_until?->toISOString(),
            isActive: $promoCode->is_active,
            applicablePackages: $promoCode->applicable_packages,
            createdAt: $promoCode->created_at?->toISOString(),
            updatedAt: $promoCode->updated_at?->toISOString(),
        );
    }
} 