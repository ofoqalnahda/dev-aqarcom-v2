<?php

namespace App\Component\Ad\Presentation\ViewModel;

use OpenApi\Attributes as OA;
use ReflectionClass;

#[OA\Schema(
    title: "AdViewModel",
    description: "Ad From Platform View Model",
    required: ["license_number"],
    properties: [
        new OA\Property(property: "license_number", type: "string"),
        new OA\Property(property: "region_name", type: "string"),

    ],
    type: "object",
)]
class AdPlatformViewModel
{
    public string $license_number;
    public ?string $region_name = null;
    public ?string $city_name;
    public ?string $neighborhood_name;
    public int $estate_type_name;
    public int $usage_type_name;
    public string $status;
    public string $address;
    public float $lng;
    public float $lat;
    public float $price;
    public bool $is_constrained;
    public bool $is_pawned;
    public bool $is_halted;
    public bool $is_testment;

    public ?float $street_width;
    public ?int $number_of_rooms;
    public ?string $advertiser_registration_number;
    public ?string $deed_number;
    public ?string $property_face;
    public ?string $plan_number;
    public ?string $land_number;
    public ?string $ad_license_url;
    public ?string $ad_source;
    public ?string $title_deed_type_name;
    public ?string $location_description;
    public ?string $property_age;
    public mixed $rerConstraints;
    public ?string $creation_date;
    public ?string $end_date;

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
