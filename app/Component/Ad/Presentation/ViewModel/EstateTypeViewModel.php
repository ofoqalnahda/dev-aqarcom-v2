<?php

namespace App\Component\Ad\Presentation\ViewModel;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "EstateTypeViewModel",
    description: "Estate Type View Model",
    required: ["id","title"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "is_most_used", type:"boolean"),
        new OA\Property(property: "title", type: "string"),

    ],
    type: "object",
)]
class EstateTypeViewModel
{
    public int $id;
    public bool $is_most_used ;
    public string $title ;

    public function __construct(array $data)
    {
        $this->id = $data["id"];
        $this->is_most_used = $data["is_most_used"];
        $this->title = $data["title"];
    }


    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
