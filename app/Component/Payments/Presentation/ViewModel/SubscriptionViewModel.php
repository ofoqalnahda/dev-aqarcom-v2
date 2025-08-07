<?php

namespace App\Component\Payments\Presentation\ViewModel;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "SubscriptionViewModel",
    description: "Subscription View Model",
    required: ["id", "user_id", "package_id", "original_price", "final_price", "payment_method", "payment_status", "subscription_status"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "user_id", type: "integer"),
        new OA\Property(property: "package_id", type: "integer"),
        new OA\Property(property: "promo_code_id", type: "integer", nullable: true),
        new OA\Property(property: "original_price", type: "number", format: "float"),
        new OA\Property(property: "final_price", type: "number", format: "float"),
        new OA\Property(property: "discount_amount", type: "number", format: "float"),
        new OA\Property(property: "discount_percentage", type: "number", format: "float"),
        new OA\Property(property: "payment_method", type: "string"),
        new OA\Property(property: "payment_status", type: "string"),
        new OA\Property(property: "subscription_status", type: "string"),
        new OA\Property(property: "start_date", type: "string", format: "date-time", nullable: true),
        new OA\Property(property: "end_date", type: "string", format: "date-time", nullable: true),
        new OA\Property(property: "transaction_id", type: "string", nullable: true),
        new OA\Property(property: "payment_details", type: "object", nullable: true),
        new OA\Property(property: "created_at", type: "string", format: "date-time", nullable: true),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", nullable: true),
        new OA\Property(property: "package", type: "object", nullable: true),
        new OA\Property(property: "promo_code", type: "object", nullable: true),
    ],
    type: "object",
)]
class SubscriptionViewModel
{
    public $id;
    public $user_id;
    public $package_id;
    public $promo_code_id;
    public $original_price;
    public $final_price;
    public $discount_amount;
    public $discount_percentage;
    public $payment_method;
    public $payment_status;
    public $subscription_status;
    public $start_date;
    public $end_date;
    public $transaction_id;
    public $payment_details;
    public $created_at;
    public $updated_at;
    public $package;
    public $promo_code;

    public function __construct($subscription)
    {
        $this->id = $subscription->id;
        $this->user_id = $subscription->user_id;
        $this->package_id = $subscription->package_id;
        $this->promo_code_id = $subscription->promo_code_id;
        $this->original_price = (float) $subscription->original_price;
        $this->final_price = (float) $subscription->final_price;
        $this->discount_amount = (float) $subscription->discount_amount;
        $this->discount_percentage = (float) $subscription->discount_percentage;
        $this->payment_method = $subscription->payment_method;
        $this->payment_status = $subscription->payment_status;
        $this->subscription_status = $subscription->subscription_status;
        $this->start_date = $subscription->start_date?->toISOString();
        $this->end_date = $subscription->end_date?->toISOString();
        $this->transaction_id = $subscription->transaction_id;
        $this->payment_details = $subscription->payment_details;
        $this->created_at = $subscription->created_at?->toISOString();
        $this->updated_at = $subscription->updated_at?->toISOString();
        $this->package = $subscription->package ? [
            'id' => $subscription->package->id,
            'name' => $subscription->package->name,
            'type' => $subscription->package->type,
            'period_months' => $subscription->package->period_months,
            'description' => $subscription->package->description,
            'features' => $subscription->package->features,
        ] : null;
        $this->promo_code = $subscription->promoCode ? [
            'id' => $subscription->promoCode->id,
            'code' => $subscription->promoCode->code,
            'description' => $subscription->promoCode->description,
            'discount_type' => $subscription->promoCode->discount_type,
            'discount_value' => (float) $subscription->promoCode->discount_value,
        ] : null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
} 