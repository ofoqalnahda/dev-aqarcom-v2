<?php

namespace App\Component\Properties\Presentation\ViewModel;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "ServiceViewModel",
    description: "Service View Model",
    required: ["id", "type", "name","image", "is_active", "created_at", "updated_at"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "type", type: "string"),
        new OA\Property(property: "type_label", type: "string"),
        new OA\Property(property: "name", type: "string"),
        new OA\Property(property: "image", type: "string"),
        new OA\Property(property: "is_active", type: "boolean"),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ],
    type: "object",
)]
class ServiceViewModel
{
    public $id;
    public $type;
    public $type_label;
    public ?string $image = '';
    public $name;
    public $is_active;
    public $created_at;
    public $updated_at;

    public function __construct($service)
    {
        if ($service) {
            $this->id = $service->id;
            $this->type = $service->type->value;
            $this->type_label = $service->type->label();
            $this->name = $service->name;
            $this->image = $service->getFirstMediaUrl('images');
            $this->is_active = $service->is_active;
            $this->created_at = $service->created_at;
            $this->updated_at = $service->updated_at;
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'type_label' => $this->type_label,
            'name' => $this->name,
            'image' => $this->image,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
