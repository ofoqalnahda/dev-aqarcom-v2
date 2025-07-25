<?php

namespace App\Component\Settings\Data\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'period_months',
        'description',
        'price',
        'price_before_discount',
        'features',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'price_before_discount' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
        'period_months' => 'integer',
        'sort_order' => 'integer',
    ];

    public function getDiscountPercentageAttribute(): ?float
    {
        if (!$this->price_before_discount || $this->price_before_discount <= $this->price) {
            return null;
        }
        
        return round((($this->price_before_discount - $this->price) / $this->price_before_discount) * 100, 2);
    }
} 