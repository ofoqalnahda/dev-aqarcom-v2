<?php

namespace App\Component\Settings\Presentation\ViewModel;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "ProfitSubscriberViewModel",
    description: "Profit Subscriber View Model",
    required: ["id", "name", "email", "phone", "status", "subscription_date", "is_active"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "user_id", type: "integer", nullable: true),
        new OA\Property(property: "name", type: "string"),
        new OA\Property(property: "email", type: "string"),
        new OA\Property(property: "phone", type: "string"),
        new OA\Property(property: "status", type: "string", enum: ["independent", "not_independent"]),
        new OA\Property(property: "subscription_date", type: "string", format: "date"),
        new OA\Property(property: "is_active", type: "boolean"),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ],
    type: "object",
)]
class ProfitSubscriberViewModel
{
    public $id;
    public $user_id;
    public $name;
    public $email;
    public $phone;
    public $status;
    public $subscription_date;
    public $is_active;
    public $created_at;
    public $updated_at;

    public function __construct($subscriber)
    {
        $this->id = $subscriber->id;
        $this->user_id = $subscriber->user_id;
        $this->name = $subscriber->name;
        $this->email = $subscriber->email;
        $this->phone = $subscriber->phone;
        $this->status = $subscriber->status;
        $this->subscription_date = $subscriber->subscription_date;
        $this->is_active = $subscriber->is_active;
        $this->created_at = $subscriber->created_at;
        $this->updated_at = $subscriber->updated_at;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
} 