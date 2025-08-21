<?php

namespace App\Component\Auth\Presentation\ViewModel;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "UserViewListModel",
    description: "User List View Model for Service Providers",
    required: ["id", "name"],
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Company Name"),
        new OA\Property(property: "image", type: "string", example: "https://example.com/image.jpg", nullable: true),
        new OA\Property(property: "user_type", type: "string", example: "office"),
        new OA\Property(property: "average_rating", type: "number", format: "float", example: 4.5, nullable: true),
        new OA\Property(property: "total_ratings", type: "integer", example: 10, nullable: true),
        new OA\Property(property: "distance", description: "Distance in kilometers from user location", type: "number", format: "float", example: 2.5),
        new OA\Property(property: "latitude", type: "number", format: "float", example: 21.422510, nullable: true),
        new OA\Property(property: "longitude", type: "number", format: "float", example: 39.826168, nullable: true),
    ],
    type: "object",
)]
class UserViewListModel
{
    public $id;
    public $name;
    public $image;
    public $user_type;
    public $average_rating;
    public $total_ratings;
    public $distance;
    public $latitude;
    public $longitude;

    public function __construct($user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->image = $user->image;
        $this->user_type = $user->user_type;
        $this->average_rating = $user->average_rating;
        $this->total_ratings = $user->rating_count;
        $this->distance = $user->distance ?? 0;
        $this->latitude = $user->latitude ?? null;
        $this->longitude = $user->longitude ?? null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}


