<?php

namespace App\Component\Ad\Presentation\ViewModel;

use OpenApi\Attributes as OA;
use ReflectionClass;

#[OA\Schema(
    title: "AdViewModel",
    description: "Ad From Platform View Model",
    required: ["id","license_number"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "license_number", type: "string"),

    ],
    type: "object",
)]
class AdViewModel
{
    public int $id;
    public string $license_number;


    public function __construct(object $ad)
    {
        $data = get_object_vars($ad);
        $classProperties = array_keys((new ReflectionClass($this))->getProperties());
        foreach ($data as $key => $value) {
            if (in_array($key, $classProperties)) {
                $this->$key = $value;
            }
        }
    }


    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
