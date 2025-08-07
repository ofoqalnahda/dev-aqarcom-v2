<?php

namespace App\Component\Payments\Presentation\ViewModel;

class PromoCodeViewModel
{
    public function __construct(
        public readonly int $id,
        public readonly string $code,
        public readonly ?string $description,
        public readonly string $discountType,
        public readonly float $discountValue,
        public readonly float $minimumAmount,
        public readonly ?float $maximumDiscount,
        public readonly ?int $usageLimit,
        public readonly int $usedCount,
        public readonly ?string $validFrom,
        public readonly ?string $validUntil,
        public readonly bool $isActive,
        public readonly ?array $applicablePackages,
        public readonly ?string $createdAt,
        public readonly ?string $updatedAt,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'description' => $this->description,
            'discount_type' => $this->discountType,
            'discount_value' => $this->discountValue,
            'minimum_amount' => $this->minimumAmount,
            'maximum_discount' => $this->maximumDiscount,
            'usage_limit' => $this->usageLimit,
            'used_count' => $this->usedCount,
            'valid_from' => $this->validFrom,
            'valid_until' => $this->validUntil,
            'is_active' => $this->isActive,
            'applicable_packages' => $this->applicablePackages,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
} 