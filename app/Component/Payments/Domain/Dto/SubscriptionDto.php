<?php

namespace App\Component\Payments\Domain\Dto;

use App\Component\Payments\Domain\Enum\PaymentMethod;
use App\Component\Payments\Domain\Enum\PaymentStatus;
use App\Component\Payments\Domain\Enum\SubscriptionStatus;

class SubscriptionDto
{
    public function __construct(
        public readonly int $userId,
        public readonly int $packageId,
        public readonly ?int $promoCodeId,
        public readonly float $originalPrice,
        public readonly float $finalPrice,
        public readonly float $discountAmount,
        public readonly float $discountPercentage,
        public readonly PaymentMethod $paymentMethod,
        public readonly PaymentStatus $paymentStatus,
        public readonly SubscriptionStatus $subscriptionStatus,
        public readonly ?string $transactionId = null,
        public readonly ?array $paymentDetails = null
    ) {}
} 