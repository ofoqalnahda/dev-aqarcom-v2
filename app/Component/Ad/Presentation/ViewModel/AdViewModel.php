<?php

namespace App\Component\Ad\Presentation\ViewModel;

use OpenApi\Attributes as OA;
use ReflectionClass;

#[OA\Schema(
       title: "AdViewModel",
       description: "Ad Sell View Model",
       properties: [
           new OA\Property(property: "id", type: "integer"),
           new OA\Property(property: "slug", type: "string", nullable: true),
           new OA\Property(property: "title", type: "string", nullable: true),
           new OA\Property(property: "date_at", type: "string", nullable: true),
           new OA\Property(property: "type_ad", type: "string", nullable: true),
           new OA\Property(property: "estate_type", type: "string", nullable: true),
           new OA\Property(property: "usage_type", type: "string", nullable: true),

           new OA\Property(property: "price", type: "integer", nullable: true),
           new OA\Property(property: "property_price", type: "integer", nullable: true),
           new OA\Property(property: "is_favorite", type: "boolean"),
           new OA\Property(property: "number_of_rooms", type: "integer", nullable: true),
           new OA\Property(property: "area", type: "string", nullable: true),

           new OA\Property(property: "license_number", type: "string"),
           new OA\Property(property: "creation_date", type: "string", format: "date"),
           new OA\Property(property: "end_date", type: "string", format: "date"),

           new OA\Property(property: "address", type: "string", nullable: true),
           new OA\Property(property: "region", type: "string", nullable: true),
           new OA\Property(property: "city", type: "string", nullable: true),
           new OA\Property(property: "neighborhood", type: "string", nullable: true),
           new OA\Property(property: "lat", type: "string", nullable: true),
           new OA\Property(property: "lng", type: "string", nullable: true),
           new OA\Property(property: "deed_number", type: "string", nullable: true),
           new OA\Property(property: "property_face", type: "string", nullable: true),
           new OA\Property(property: "plan_number", type: "string", nullable: true),
           new OA\Property(property: "land_number", type: "string", nullable: true),

           new OA\Property(property: "street_width", type: "string", nullable: true),
           new OA\Property(property: "ad_license_url", type: "string", nullable: true),
           new OA\Property(property: "is_constrained", type: "boolean"),
           new OA\Property(property: "is_pawned", type: "boolean"),
           new OA\Property(property: "is_halted", type: "boolean"),

           new OA\Property(property: "is_testament", type: "boolean"),
           new OA\Property(property: "title_deed_type_name", type: "string"),

           new OA\Property(property: "description", type: "string", nullable: true),

           new OA\Property(property: "video", type: "string", nullable: true),
           new OA\Property(property: "images", type: "array", items: new OA\Items(type: "string"), nullable: true),
           new OA\Property(property: "user", type: "object", nullable: true),
       ],
       type: "object",
)]
class AdViewModel
{
    public int $id;
    public ?string $slug = null;
    public ?string $title = null;
    public ?string $date_at = null;
    public ?string $type_ad = null;
    public ?string $estate_type = null;
    public ?string $usage_type = null;

    public ?int $price = null;
    public ?int $property_price = null;
    public bool $is_favorite = false;
    public ?int $number_of_rooms = null;
    public ?string $area = null;

    public ?string $license_number = '';
    public string $creation_date='';
    public string $end_date='';


    public ?string $address = null;
    public ?string $region = '';
    public ?string $city = '';
    public ?string $neighborhood = '';
    public ?string $lat = '';
    public ?string $lng = '';
    public ?string $deed_number = '';
    public ?string $property_face = '';
    public ?string $plan_number = '';
    public ?string $land_number = '';

    public ?string $street_width = '';
    public ?string $ad_license_url = '';
    public bool $is_constrained=false;
    public bool $is_pawned=false;
    public bool $is_halted=false;

    public bool $is_testament=false;
    public string $title_deed_type_name='';


    public ?string $description = '';


    public ?string $video = '';
    public ?array $images = [];
    public ?array $user = [];
    public function __construct(object $data)
    {
        $user = $data->user;

        $this->id = $data->id;
        $this->slug = $data->slug;
        $this->title = $data->title;
        $this->date_at = optional($data->created_at)
//            ->locale()
            ->isoFormat('D MMMM YYYY');
        $this->type_ad = $data->ad_type?->title;
        $this->estate_type = $data->estateType?->title;
        $this->usage_type = $data->usageType?->title;

        $this->price = $data->price;
        $this->property_price = $data->property_price;
        $this->is_favorite = auth()->check() && $data->favoritedByUsers->contains(auth()->id());
        $this->address = $data->region?->name .', '.$data->city?->name.', '.$data->neighborhood?->name;

        $this->number_of_rooms = $data->number_of_rooms;
        $this->area = $data->area ? number_format(round($data->area, 2), 2, '.', '') : null;

        $this->license_number = $data->license_number;
        $this->creation_date = optional($data->creation_date)->format('Y-m-d');
        $this->end_date = optional($data->end_date)->format('Y-m-d');
        $this->region = $data->region?->name;
        $this->city = $data->city?->name;
        $this->neighborhood = $data->neighborhood?->name;
        $this->lat = $data->lat;
        $this->lng = $data->lng;

        $this->deed_number = $data->deed_number;
        $this->property_face = $data->property_face;
        $this->plan_number = $data->plan_number;
        $this->land_number = $data->land_number;
        $this->street_width = $data->street_width;
        $this->ad_license_url = $data->ad_license_url;

        $this->is_constrained = (bool) $data->is_constrained;
        $this->is_pawned = (bool) $data->is_pawned;
        $this->is_halted = (bool) $data->is_halted;
        $this->is_testament = (bool) $data->is_testament;
        $this->title_deed_type_name = $data->title_deed_type_name;

        $this->description = $data->description;


        $this->video = $data->getFirstMediaUrl('video');
        $mainImage = $data->getFirstMediaUrl('main_image');
        $otherImages = $data->getMedia('images')->map(function ($media) {
            return $media->getFullUrl();
        })->toArray();
        $this->images = array_merge(
            $mainImage ? [$mainImage] : [],
            $otherImages
        );

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
