<?php

namespace App\Component\Settings\Presentation\ViewModel;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "SettingViewModel",
    description: "Setting View Model",
    required: ["id", "key", "value", "type", "is_public", "created_at", "updated_at"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "key", type: "string"),
        new OA\Property(property: "value", type: "object"),
        new OA\Property(property: "type", type: "string"),
        new OA\Property(property: "user_id", type: "integer", nullable: true),
        new OA\Property(property: "is_public", type: "boolean"),
        new OA\Property(property: "description", type: "string", nullable: true),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ],
    type: "object",
)]
class SettingViewModel
{
    public $id;
    public $key;
    public $value;
    public $type;
    public $user_id;
    public $is_public;
    public $description;
    public $created_at;
    public $updated_at;

    public function __construct($setting)
    {
        $this->id = $setting->id;
        $this->key = $setting->key;
        $this->value = $setting->value;
        $this->type = $setting->type;
        $this->user_id = $setting->user_id;
        $this->is_public = $setting->is_public;
        $this->description = $setting->description;
        $this->created_at = $setting->created_at;
        $this->updated_at = $setting->updated_at;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
} 