<?php

namespace App\Component\Ad\Presentation\ViewModel;

use OpenApi\Attributes as OA;
use ReflectionClass;

#[OA\Schema(
    title: "AdViewListModel",
    description: "Ad List View Model",
    required: ["id","slug"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "slug", type: "string"),
        new OA\Property(property: "title", type: "string"),
        new OA\Property(property: "price", type: "integer"),
        new OA\Property(property: "property_price", type: "integer"),
        new OA\Property(property: "is_favorite", type: "boolean"),
        new OA\Property(property: "is_special", type: "boolean"),
        new OA\Property(property: 'images', type: 'array', items: new OA\Items(type: 'string')),
        new OA\Property(property: "distance", type: "integer"),
        new OA\Property(property: "address", type: "string"),
        new OA\Property(property: "number_of_rooms", type: "integer"),
        new OA\Property(property: "area", type: "double"),
        new OA\Property(property: "user_id", type: "integer"),
        new OA\Property(property: "user_number", type: "string"),
    ],
    type: "object",
)]
class AdViewListModel
{
    public int $id;
    public ?string $slug = null;
    public ?string $title = null;
    public ?int $price = null;
    public ?int $property_price = null;
    public bool $is_favorite = false;
    public bool $is_special = false;
    public array $images = [];
    public ?int $distance = null;
    public ?string $address = null;
    public ?int $number_of_rooms = null;
    public ?float $area = null;
    public ?int $user_id = null;
    public ?string $user_number = null;

    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->slug = $data->slug;
        $this->title = $data->title;
        $this->price = $data->price;
        $this->property_price = $data->property_price;
        $this->is_favorite = auth()->check() && $data->favoritedByUsers->contains(auth()->id());
        $this->is_special = $data->is_special;

        $mainImage = $data->getFirstMediaUrl('main_image');
        $otherImages = $data->getMedia('images')->take(2)->map(function ($media) {
            return $media->getFullUrl();
        })->toArray();
        $this->images = array_merge(
            $mainImage ? [$mainImage] : [],
            $otherImages
        );
        $this->distance = round($data->distance_for_user, 2);
        $this->address = $data->address;
        $this->number_of_rooms = $data->number_of_rooms;
        $this->area = $data->area;
        $this->user_id = $data->user_id;
        $this->user_number = $data->user_number;
    }


    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
