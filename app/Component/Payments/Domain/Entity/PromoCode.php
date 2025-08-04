<?php

namespace App\Component\Payments\Domain\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'discount_type', // percentage, fixed_amount
        'discount_value',
        'minimum_amount',
        'maximum_discount',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
        'applicable_packages', // JSON array of package IDs
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'applicable_packages' => 'array',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function isExpired(): bool
    {
        return $this->valid_until && now()->isAfter($this->valid_until);
    }

    public function isUsageLimitReached(): bool
    {
        return $this->usage_limit && $this->used_count >= $this->usage_limit;
    }

    public function canBeUsed(): bool
    {
        return $this->is_active && !$this->isExpired() && !$this->isUsageLimitReached();
    }

    public function calculateDiscount(float $originalPrice): float
    {
        if ($this->discount_type === 'percentage') {
            $discount = ($originalPrice * $this->discount_value) / 100;
            return min($discount, $this->maximum_discount ?? $discount);
        }

        return min($this->discount_value, $originalPrice);
    }
} 