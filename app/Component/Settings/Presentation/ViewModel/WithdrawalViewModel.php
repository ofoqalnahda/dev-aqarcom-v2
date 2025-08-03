<?php

namespace App\Component\Settings\Presentation\ViewModel;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "WithdrawalViewModel",
    description: "Withdrawal Request View Model",
    required: ["id", "user_id", "account_number", "account_holder_name", "amount", "status", "requested_at"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "user_id", type: "integer"),
        new OA\Property(property: "account_number", type: "string"),
        new OA\Property(property: "account_holder_name", type: "string"),
        new OA\Property(property: "amount", type: "number", format: "decimal"),
        new OA\Property(property: "status", type: "string", enum: ["pending", "accepted", "rejected"]),
        new OA\Property(property: "requested_at", type: "string", format: "date-time"),
        new OA\Property(property: "processed_at", type: "string", format: "date-time", nullable: true),
        new OA\Property(property: "rejection_reason", type: "string", nullable: true),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ],
    type: "object",
)]
class WithdrawalViewModel
{
    public $id;
    public $user_id;
    public $account_number;
    public $account_holder_name;
    public $amount;
    public $status;
    public $requested_at;
    public $processed_at;
    public $rejection_reason;
    public $created_at;
    public $updated_at;

    public function __construct($withdrawalRequest)
    {
        $this->id = $withdrawalRequest->id;
        $this->user_id = $withdrawalRequest->user_id;
        $this->account_number = $withdrawalRequest->account_number;
        $this->account_holder_name = $withdrawalRequest->account_holder_name;
        $this->amount = $withdrawalRequest->amount;
        $this->status = $withdrawalRequest->status;
        $this->requested_at = $withdrawalRequest->requested_at;
        $this->processed_at = $withdrawalRequest->processed_at;
        $this->rejection_reason = $withdrawalRequest->rejection_reason;
        $this->created_at = $withdrawalRequest->created_at;
        $this->updated_at = $withdrawalRequest->updated_at;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
} 