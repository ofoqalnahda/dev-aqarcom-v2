<?php

namespace App\Component\Ad\Presentation\ViewModel;

use OpenApi\Attributes as OA;
use ReflectionClass;

#[OA\Schema(
    title: "AdViewModel",
    description: "Ad If Already exists View Model",
    required: ["license_number"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "slug", type: "string"),
        new OA\Property(property: "license_number", type: "string"),
        new OA\Property(property: "user_name", type: "string"),
        new OA\Property(property: "user_id", type: "integer")
    ],
    type: "object",
)]
class
AdExistsAdViewModel
{
    public int $id;
    public string $slug;
    public string $license_number;
    public ?string $user_name;
    public string $user_id;

    public function __construct($data)
    {
        $this->id = $data["id"];
        $this->slug = $data["slug"];
        $this->license_number = $data["license_number"];
        $this->user_name = $data["user_name"];
        $this->user_id = $data["user_id"];
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}




