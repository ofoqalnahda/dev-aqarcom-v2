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
        return new SubscriptionViewModel(
            id: $subscription->id,
            userId: $subscription->user_id,
            packageId: $subscription->package_id,
            promoCodeId: $subscription->promo_code_id,
            originalPrice: (float) $subscription->original_price,
            finalPrice: (float) $subscription->final_price,
            discountAmount: (float) $subscription->discount_amount,
            discountPercentage: (float) $subscription->discount_percentage,
            paymentMethod: $subscription->payment_method,
            paymentStatus: $subscription->payment_status,
            subscriptionStatus: $subscription->subscription_status,
            startDate: $subscription->start_date?->toISOString(),
            endDate: $subscription->end_date?->toISOString(),
            transactionId: $subscription->transaction_id,
            paymentDetails: $subscription->payment_details,
            createdAt: $subscription->created_at?->toISOString(),
            updatedAt: $subscription->updated_at?->toISOString(),
            package: $subscription->package ? [
                'id' => $subscription->package->id,
                'name' => $subscription->package->name,
                'type' => $subscription->package->type,
                'period_months' => $subscription->package->period_months,
                'description' => $subscription->package->description,
                'features' => $subscription->package->features,
            ] : null,
            promoCode: $subscription->promoCode ? [
                'id' => $subscription->promoCode->id,
                'code' => $subscription->promoCode->code,
                'description' => $subscription->promoCode->description,
                'discount_type' => $subscription->promoCode->discount_type,
                'discount_value' => (float) $subscription->promoCode->discount_value,
            ] : null,
        );
    }
    
    public function toSubscriptionViewModelCollection(array $subscriptions): array
    {
        return array_map(function ($subscription) {
            if ($subscription instanceof Subscription) {
                return $this->toSubscriptionViewModel($subscription);
            }
            return $subscription;
        }, $subscriptions);
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