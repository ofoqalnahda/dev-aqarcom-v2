<?php

namespace App\Component\Ad\Presentation\ViewModel;

use OpenApi\Attributes as OA;
use ReflectionClass;

#[OA\Schema(
    title: "AdBuyViewModel",
    description: "Ad buy View Model",
    required: ["id"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "slug", type: "string", nullable: true),
        new OA\Property(property: "title", type: "string", nullable: true),
        new OA\Property(property: "type_ad", type: "string", nullable: true),
        new OA\Property(property: "estate_type", type: "string", nullable: true),
        new OA\Property(property: "usage_type", type: "string", nullable: true),
        new OA\Property(property: "price", type: "integer", nullable: true),
        new OA\Property(property: "creation_date", description: "Relative time (e.g. منذ يومين)", type: "string"),
        new OA\Property(property: "address", type: "string", nullable: true),
        new OA\Property(property: "region", type: "string", nullable: true),
        new OA\Property(property: "city", type: "string", nullable: true),
        new OA\Property(property: "neighborhood", type: "string", nullable: true),
        new OA\Property(property: "description", type: "string", nullable: true),

        new OA\Property(
            property: "user",
            properties: [
                new OA\Property(property: "id", type: "integer"),
                new OA\Property(property: "name", type: "string"),
                new OA\Property(property: "is_verified", type: "boolean"),
                new OA\Property(property: "whatsapp", type: "string", nullable: true),
                new OA\Property(property: "number", type: "string", nullable: true),
                new OA\Property(property: "is_follow", type: "boolean"),
                new OA\Property(
                    property: "rating_stats",
                    properties: [
                        new OA\Property(property: "average_rating", type: "number", format: "float"),
                        new OA\Property(property: "total_ratings", type: "integer"),
                        new OA\Property(property: "ratings_given_count", type: "integer"),
                    ],
                    type: "object"
                ),
            ],
            type: "object",
            nullable: true
        ),
    ],
    type: "object",
)]
class AdBuyViewModel
{
    public int $id;
    public ?string $slug = null;
    public ?string $title = null;
    public ?string $type_ad = null;
    public ?string $estate_type = null;
    public ?string $usage_type = null;

    public ?int $price = null;
    public string $creation_date='';
    public ?string $address = null;
    public ?string $region = '';
    public ?string $city = '';
    public ?string $neighborhood = '';
    public ?string $description = '';
    public ?array $user = [];
    public function __construct(object $data)
    {
        $user = $data->user;
        $this->id = $data->id;
        $this->slug = $data->slug;
        $this->title = $data->title;
        $this->type_ad = $data->ad_type?->title;
        $this->estate_type = $data->estateType?->title;
        $this->usage_type = $data->usageType?->title;

        $this->price = $data->price;
        $this->address = $data->region?->name .', '.$data->city?->name.', '.$data->neighborhood?->name;

        $this->creation_date = optional($data->created_at)->diffForHumans();
        $this->region = $data->region?->name;
        $this->city = $data->city?->name;
        $this->neighborhood = $data->neighborhood?->name;
        $this->description = $data->description;
        $this->user = [
            "id" => $user?->id,
            "name" => $user?->name,
            "is_verified" => $user?->is_nafath_verified,
            "whatsapp" => $user?->whatsapp,
            "number" => $user?->phone,
            "is_follow" => false,
            "rating_stats" => [
                "average_rating" => $user?->average_rating,
                "total_ratings" => $user?->rating_count,
                "ratings_given_count" => $user?->ratings_given_count,
            ],
        ];
    }



    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
