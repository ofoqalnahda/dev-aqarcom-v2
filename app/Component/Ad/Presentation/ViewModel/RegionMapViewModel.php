<?php

namespace App\Component\Ad\Presentation\ViewModel;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "RegionMapViewModel",
    description: "Region Map View Model",
    required: ["id","title"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "title", type: "string"),

    ],
    type: "object",
)]
class RegionMapViewModel
{
    public int $id;
    public string $title ;

    public function __construct(array $data)
    {
        $this->id = $data["id"];
        $this->title = $data["name"];
    }


    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
