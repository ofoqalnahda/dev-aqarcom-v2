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
        new OA\Property(property: "user_type", type: "string", example: "individual"),
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
        new OA\Property(property: "about_company", type: "string", nullable: true),
        new OA\Property(property: "working_hours", type: "array", nullable: true, items: new OA\Items(
            type: "object",
            properties: [
                new OA\Property(property: "id", type: "integer"),
                new OA\Property(property: "day", type: "string"),
                new OA\Property(property: "start_time", type: "string", nullable: true),
                new OA\Property(property: "end_time", type: "string", nullable: true),
                new OA\Property(property: "is_working_day", type: "boolean"),
            ]
        )),
        new OA\Property(property: "previous_work_history", type: "array", nullable: true, items: new OA\Items(
            type: "object",
            properties: [
                new OA\Property(property: "id", type: "integer"),
                new OA\Property(property: "company_name", type: "string"),
                new OA\Property(property: "description", type: "string"),
                new OA\Property(property: "start_date", type: "string", format: "date", nullable: true),
                new OA\Property(property: "end_date", type: "string", format: "date", nullable: true),
                new OA\Property(property: "is_current_job", type: "boolean"),
            ]
        )),
        new OA\Property(property: "services", type: "array", nullable: true, items: new OA\Items(
            type: "object",
            properties: [
                new OA\Property(property: "id", type: "integer"),
                new OA\Property(property: "name", type: "string"),
                new OA\Property(property: "type", type: "string"),
            ]
        )),
        new OA\Property(property: "rating_stats", type: "object", nullable: true, properties: [
            new OA\Property(property: "average_rating", type: "number", format: "float", example: 4.5),
            new OA\Property(property: "total_ratings", type: "integer", example: 10),
            new OA\Property(property: "ratings_given_count", type: "integer", example: 5),
        ]),
        new OA\Property(property: "distance", type: "number", format: "float", description: "Distance in kilometers from user location", example: 2.5),
        new OA\Property(property: "ratings_received", type: "array", nullable: true, items: new OA\Items(
            type: "object",
            properties: [
                new OA\Property(property: "id", type: "integer"),
                new OA\Property(property: "rating", type: "integer", minimum: 1, maximum: 5),
                new OA\Property(property: "description", type: "string", nullable: true),
                new OA\Property(property: "user", type: "object", properties: [
                    new OA\Property(property: "id", type: "integer"),
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "email", type: "string"),
                ]),
                new OA\Property(property: "created_at", type: "string", format: "date-time"),
            ]
        )),
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
    public $user_type;
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
    public $latitude;
    public $longitude;
    public $address;
    public $about_company;
    public $working_hours;
    public $previous_work_history;
    public $services;
    public $rating_stats;
    public $ratings_received;
    public $distance;
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
        $this->user_type = $user->user_type;
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
        $this->latitude = $user->latitude;
        $this->longitude = $user->longitude;
        $this->address = $user->address;
        $this->val_license = $user->val_license;
        $this->transId = $user->transId;
        $this->requestId = $user->requestId;
        $this->is_nafath_verified = $user->is_nafath_verified;
        $this->about_company = $user->about_company;
        $this->working_hours = $user->workingHours ? $user->workingHours->map(function($wh) {
            return [
                'id' => $wh->id,
                'day' => $wh->day,
                'start_time' => $wh->start_time ? $wh->start_time->format('H:i') : null,
                'end_time' => $wh->end_time ? $wh->end_time->format('H:i') : null,
                'is_working_day' => $wh->is_working_day,
            ];
        })->toArray() : null;
        $this->previous_work_history = $user->previousWorkHistory ? $user->previousWorkHistory->map(function($pwh) {
            return [
                'id' => $pwh->id,
                'company_name' => $pwh->company_name,
                'description' => $pwh->description,
                'start_date' => $pwh->start_date ? $pwh->start_date->format('Y-m-d') : null,
                'end_date' => $pwh->end_date ? $pwh->end_date->format('Y-m-d') : null,
                'is_current_job' => $pwh->is_current_job,
            ];
        })->toArray() : null;
        $this->services = $user->services ? $user->services->map(function($service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'type' => $service->type->value,
            ];
        })->toArray() : null;
        $this->rating_stats = [
            'average_rating' => $user->average_rating,
            'total_ratings' => $user->rating_count,
            'ratings_given_count' => $user->ratings_given_count,
        ];
        $this->ratings_received = $user->ratingsReceived ? $user->ratingsReceived->map(function($rating) {
            return [
                'id' => $rating->id,
                'rating' => $rating->rating,
                'description' => $rating->description,
                'user' => [
                    'id' => $rating->user->id,
                    'name' => $rating->user->name,
                    'email' => $rating->user->email,
                ],
                'created_at' => $rating->created_at,
            ];
        })->toArray() : null;
        $this->distance = $user->distance;
        $this->created_at = $user->created_at;
        $this->updated_at = $user->updated_at;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
