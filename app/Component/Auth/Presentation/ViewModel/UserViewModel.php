<?php

namespace App\Component\Auth\Presentation\ViewModel;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "UserViewModel",
    description: "User View Model",
    required: ["id", "email", "phone", "is_active", "created_at", "updated_at"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "name", type: "string", nullable: true),
        new OA\Property(property: "email", type: "string"),
        new OA\Property(property: "phone", type: "string"),
        new OA\Property(property: "whatsapp", type: "string"),
        new OA\Property(property: "image", type: "string", nullable: true),
        new OA\Property(property: "code", type: "string", nullable: true),
        new OA\Property(property: "is_verified", type: "boolean"),
        new OA\Property(property: "is_active", type: "boolean"),
        new OA\Property(property: "receive_notification", type: "boolean"),
        new OA\Property(property: "receive_messages", type: "boolean"),
        new OA\Property(property: "free_ads", type: "integer"),
        new OA\Property(property: "device_token", type: "string", nullable: true),
        new OA\Property(property: "last_login", type: "string", format: "date-time", nullable: true),
        new OA\Property(property: "is_authentic", type: "boolean"),
        new OA\Property(property: "pending_authentication", type: "boolean"),
        new OA\Property(property: "identity_owner_name", type: "string", nullable: true),
        new OA\Property(property: "identity_number", type: "string", nullable: true),
        new OA\Property(property: "commercial_owner_name", type: "string", nullable: true),
        new OA\Property(property: "commercial_name", type: "string", nullable: true),
        new OA\Property(property: "commercial_number", type: "string", nullable: true),
        new OA\Property(property: "commercial_image", type: "string", nullable: true),
        new OA\Property(property: "identity_image", type: "string", nullable: true),
        new OA\Property(property: "val_license", type: "string", nullable: true),
        new OA\Property(property: "transId", type: "string", nullable: true),
        new OA\Property(property: "requestId", type: "string", nullable: true),
        new OA\Property(property: "is_nafath_verified", type: "boolean"),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ],
    type: "object",
)]
class UserViewModel
{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $whatsapp;
    public $image;
    public $code;
    public $is_verified;
    public $is_active;
    public $receive_notification;
    public $receive_messages;
    public $free_ads;
    public $device_token;
    public $last_login;
    public $is_authentic;
    public $pending_authentication;
    public $identity_owner_name;
    public $identity_number;
    public $commercial_owner_name;
    public $commercial_name;
    public $commercial_number;
    public $commercial_image;
    public $identity_image;
    public $val_license;
    public $transId;
    public $requestId;
    public $is_nafath_verified;
    public $created_at;
    public $updated_at;

    public function __construct($user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->whatsapp = $user->whatsapp;
        $this->image = $user->image;
        $this->is_verified = $user->is_verified;
        $this->is_active = $user->is_active;
        $this->receive_notification = $user->receive_notification;
        $this->receive_messages = $user->receive_messages;
        $this->free_ads = $user->free_ads;
        $this->device_token = $user->device_token;
        $this->last_login = $user->last_login;
        $this->is_authentic = $user->is_authentic;
        $this->pending_authentication = $user->pending_authentication;
        $this->identity_owner_name = $user->identity_owner_name;
        $this->identity_number = $user->identity_number;
        $this->commercial_owner_name = $user->commercial_owner_name;
        $this->commercial_name = $user->commercial_name;
        $this->commercial_number = $user->commercial_number;
        $this->commercial_image = $user->commercial_image;
        $this->identity_image = $user->identity_image;
        $this->val_license = $user->val_license;
        $this->transId = $user->transId;
        $this->requestId = $user->requestId;
        $this->is_nafath_verified = $user->is_nafath_verified;
        $this->created_at = $user->created_at;
        $this->updated_at = $user->updated_at;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
