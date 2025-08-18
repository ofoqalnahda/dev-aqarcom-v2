<?php

namespace App\Component\Ad\Presentation\ViewModel;

use OpenApi\Attributes as OA;
use ReflectionClass;

#[OA\Schema(
    title: "AdBuyViewListModel",
    description: "Ad Buy List View Model",
    required: ["id","slug"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "slug", type: "string"),
        new OA\Property(property: "title", type: "string"),
        new OA\Property(property: "price", type: "integer"),
        new OA\Property(property: "date", type: "string"),
        new OA\Property(property: "estate_type", type: "string"),
        new OA\Property(property: "ad_type", type: "string"),
        new OA\Property(property: "address", type: "integer"),
        new OA\Property(property: "user_id", type: "integer"),
        new OA\Property(property: "user_number", type: "string"),
        new OA\Property(property: "user_whatsapp", type: "string"),
    ],
    type: "object",
)]
class AdBuyViewListModel
{
    public int $id;
    public ?string $slug = null;
    public ?string $title = null;
    public ?int $price = null;
    public ?string $date = null;
    public ?string $estate_type = null;
    public ?string $ad_type = null;
    public ?string $address = null;
    public ?int $user_id = null;
    public ?string $user_number = null;
    public ?string $user_whatsapp = null;

    public function __construct(object $data)
    {


        $user=$data->user;

        $this->id = $data->id;
        $this->slug = $data->slug;
        $this->title = $data->title;
        $this->price = $data->price;
        $this->date = $data->created_at?->diffForHumans();
        $this->estate_type = $data->estateType->title;
        $this->ad_type = $data->ad_type->title;
        $this->address = $data->neighborhood?->name.' - '.$data->city?->name;
        $this->user_id = $data->user_id;
        $this->user_number = $user?->phone;
        $this->user_whatsapp = $user?->phone;
    }


    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
