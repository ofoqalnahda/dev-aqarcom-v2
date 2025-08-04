<?php

namespace App\Component\Payments\Presentation\ViewModel;

class SubscriptionViewModel
{
    public function __construct(
        public readonly int $id,
        public readonly int $userId,
        public readonly int $packageId,
        public readonly ?int $promoCodeId,
        public readonly float $originalPrice,
        public readonly float $finalPrice,
        public readonly float $discountAmount,
        public readonly float $discountPercentage,
        public readonly string $paymentMethod,
        public readonly string $paymentStatus,
        public readonly string $subscriptionStatus,
        public readonly ?string $startDate,
        public readonly ?string $endDate,
        public readonly ?string $transactionId,
        public readonly ?array $paymentDetails,
        public readonly ?string $createdAt,
        public readonly ?string $updatedAt,
        public readonly ?array $package,
        public readonly ?array $promoCode,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'package_id' => $this->packageId,
            'promo_code_id' => $this->promoCodeId,
            'original_price' => $this->originalPrice,
            'final_price' => $this->finalPrice,
            'discount_amount' => $this->discountAmount,
            'discount_percentage' => $this->discountPercentage,
            'payment_method' => $this->paymentMethod,
            'payment_status' => $this->paymentStatus,
            'subscription_status' => $this->subscriptionStatus,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'transaction_id' => $this->transactionId,
            'payment_details' => $this->paymentDetails,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'package' => $this->package,
            'promo_code' => $this->promoCode,
        ];
    }
} 