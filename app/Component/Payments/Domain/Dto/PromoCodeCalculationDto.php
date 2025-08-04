<?php

namespace App\Component\Payments\Domain\Dto;

class PromoCodeCalculationDto
{
    public function __construct(
        public readonly int $packageId,
        public readonly float $originalPrice,
        public readonly float $finalPrice,
        public readonly float $discountAmount,
        public readonly float $discountPercentage,
        public readonly ?string $promoCode = null,
        public readonly ?string $errorMessage = null,
        public readonly bool $isValid = true
    ) {}

    public static function createValid(
        int $packageId,
        float $originalPrice,
        float $finalPrice,
        float $discountAmount,
        float $discountPercentage,
        ?string $promoCode = null
    ): self {
        return new self(
            packageId: $packageId,
            originalPrice: $originalPrice,
            finalPrice: $finalPrice,
            discountAmount: $discountAmount,
            discountPercentage: $discountPercentage,
            promoCode: $promoCode,
            isValid: true
        );
    }

    public static function createInvalid(
        int $packageId,
        float $originalPrice,
        string $errorMessage
    ): self {
        return new self(
            packageId: $packageId,
            originalPrice: $originalPrice,
            finalPrice: $originalPrice,
            discountAmount: 0,
            discountPercentage: 0,
            errorMessage: $errorMessage,
            isValid: false
        );
    }
} 