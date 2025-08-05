<?php

namespace App\Component\Payments\Domain\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Component\Settings\Data\Entity\Package;
use App\Models\User;
use App\Component\Payments\Domain\Entity\PromoCode;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'promo_code_id',
        'original_price',
        'final_price',
        'discount_amount',
        'discount_percentage',
        'payment_method',
        'payment_status',
        'subscription_status',
        'start_date',
        'end_date',
        'transaction_id',
        'payment_details',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'payment_details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }
} 