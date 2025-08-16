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
        new OA\Property(property: "image", type: "string", nullable: true, example: "https://example.com/image.jpg"),
        new OA\Property(property: "user_type", type: "string", example: "office"),
        new OA\Property(property: "average_rating", type: "number", format: "float", nullable: true, example: 4.5),
        new OA\Property(property: "total_ratings", type: "integer", nullable: true, example: 10),
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

    public function __construct($user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->image = $user->image;
        $this->user_type = $user->user_type;
        $this->average_rating = $user->average_rating;
        $this->total_ratings = $user->rating_count;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

