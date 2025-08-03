<?php

namespace App\Component\Ad\Presentation\ViewModel;

use App\Component\Ad\Data\Entity\Ad\AdType;
use App\Component\Ad\Data\Entity\Ad\EstateType;
use App\Component\Ad\Data\Entity\Ad\PropertyUtility;
use App\Component\Ad\Data\Entity\Ad\UsageType;
use App\Component\Ad\Data\Entity\Geography\City;
use App\Component\Ad\Data\Entity\Geography\Neighborhood;
use App\Component\Ad\Data\Entity\Geography\Region;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;
use ReflectionClass;

#[OA\Schema(
    title: "AdPlatformViewModel",
    description: "Ad From Platform View Model",
    required: ["license_number"],
    properties: [
        new OA\Property(property: "license_number", type: "string"),
        new OA\Property(property: "advertiser_name", type: "string"),
        new OA\Property(property: "advertiser_phone", type: "string"),
        new OA\Property(property: "price", type: "number", format: "float"),
        new OA\Property(property: "property_price", type: "number", format: "float"),

        new OA\Property(property: "region", type: "object"),
        new OA\Property(property: "city", type: "object"),
        new OA\Property(property: "neighborhood", type: "object"),

        new OA\Property(property: "estate_type", type: "object"),
        new OA\Property(property: "usage_type", type: "object"),
        new OA\Property(property: "ad_type", type: "object"),
        new OA\Property(property: "property_utilities", type: "array", items: new OA\Items(type: "object")),

        new OA\Property(property: "address", type: "string"),
        new OA\Property(property: "lng", type: "number", format: "float"),
        new OA\Property(property: "lat", type: "number", format: "float"),

        new OA\Property(property: "is_constrained", type: "boolean"),
        new OA\Property(property: "is_pawned", type: "boolean"),
        new OA\Property(property: "is_halted", type: "boolean"),
        new OA\Property(property: "is_testment", type: "boolean"),

        new OA\Property(property: "street_width", type: "number", format: "float", nullable: true),
        new OA\Property(property: "number_of_rooms", type: "integer", nullable: true),
        new OA\Property(property: "area", type: "string", nullable: true),
        new OA\Property(property: "deed_number", type: "string", nullable: true),
        new OA\Property(property: "property_face", type: "string", nullable: true),
        new OA\Property(property: "plan_number", type: "string", nullable: true),
        new OA\Property(property: "land_number", type: "string", nullable: true),
        new OA\Property(property: "ad_license_url", type: "string", nullable: true),
        new OA\Property(property: "ad_source", type: "string", nullable: true),
        new OA\Property(property: "title_deed_type_name", type: "string", nullable: true),
        new OA\Property(property: "location_description", type: "string", nullable: true),
        new OA\Property(property: "property_age", type: "string", nullable: true),
        new OA\Property(property: "rerConstraints", type: "array", items: new OA\Items(type: "string"), nullable: true),
        new OA\Property(property: "creation_date", type: "string", format: "date-time", nullable: true),
        new OA\Property(property: "end_date", type: "string", format: "date-time", nullable: true),
    ]
    ,
    type: "object",
)]
class AdPlatformViewModel
{
    public string $license_number;
    public string $advertiser_name;
    public string $advertiser_phone;

    public float $price;
    public float $property_price;
    public array $region;

    public array $city;
    public array $neighborhood;

    public array $estate_type;

    public array $usage_type;
    public array $ad_type;
    public array $property_utilities;

    public string $address;
    public float $lng;
    public float $lat;

    public bool $is_constrained;
    public bool $is_pawned;
    public bool $is_halted;
    public bool $is_testment;

    public ?float $street_width;
    public ?int $number_of_rooms;
    public ?string $area;
    public ?string $deed_number;
    public ?string $property_face;
    public ?string $plan_number;
    public ?string $land_number;
    public ?string $ad_license_url;
    public ?string $ad_source;
    public ?string $title_deed_type_name;
    public ?string $location_description;
    public ?string $property_age;
    public ?array $rerConstraints;
    public ?string $creation_date;
    public ?string $end_date;

    public function __construct(array $advertisement)
    {

        $this->license_number=$advertisement['adLicenseNumber'];
        $this->advertiser_name =$advertisement['advertiserName'];
        $this->advertiser_phone =$advertisement['phoneNumber'];

        $this->price=convert_to_english_numbers($advertisement['propertyPrice']);
        $this->property_price=convert_to_english_numbers($advertisement['propertyPrice']);
        if($advertisement['landTotalAnnualRent']){
            $this->price=convert_to_english_numbers($advertisement['landTotalAnnualRent']);
        }elseif($advertisement['landTotalPrice']){
            $this->price=convert_to_english_numbers($advertisement['landTotalPrice']);

        }

        $this->region = $this->findOrCreateTranslatable(Region::class, 'name', $advertisement['location']['region']);
        $this->city = $this->findOrCreateTranslatable(City::class, 'name', $advertisement['location']['city'], ['region_id' => $this->region['id']]);
        $this->neighborhood = $this->findOrCreateTranslatable(Neighborhood::class, 'name', $advertisement['location']['district'], ['city_id' => $this->city['id']]);
        $this->estate_type = $this->findOrCreateTranslatable(EstateType::class, 'title', $advertisement['propertyType']);
        $this->usage_type = $this->findOrCreateTranslatable(UsageType::class, 'title', $advertisement['mainLandUseTypeName']);
        $this->ad_type = $this->findOrCreateTranslatable(AdType::class, 'title', $advertisement['advertisementType']);

        $property_utilities=[];
        foreach ($advertisement['propertyUtilities'] ?? [] as $utility_name) {
            $utility = $this->findOrCreateTranslatable(PropertyUtility::class, 'title', $utility_name);
            $property_utilities[] = $utility;
        }
        $this->property_utilities=$property_utilities;






        $this->address =$this->region['name'] .'-'.$this->city['name'].'-'.$this->neighborhood['name'].'-'. $advertisement['location']['street'];
        $this->lat =$advertisement['location']['latitude']?:"21.422510";
        $this->lng =$advertisement['location']['longitude']?:"39.826168";

        $this->is_constrained =$advertisement['isConstrained'];
        $this->is_pawned =$advertisement['isPawned'];
        $this->is_halted =$advertisement['isHalted'];
        $this->is_testment =$advertisement['isTestment'];



        $this->street_width =$advertisement['streetWidth'];
        $this->number_of_rooms =$advertisement['numberOfRooms'];
        $this->deed_number =$advertisement['deedNumber'];
        $this->property_face =$advertisement['propertyFace'];
        $this->plan_number =$advertisement['planNumber'];
        $this->land_number =$advertisement['landNumber'];
        $this->ad_license_url =$advertisement['adLicenseUrl'];
        $this->ad_source =$advertisement['adSource'];
        $this->title_deed_type_name =$advertisement['titleDeedTypeName'];
        $this->location_description =$advertisement['locationDescriptionOnMOJDeed'];
        $this->property_age =$advertisement['propertyAge'];
        $this->rerConstraints =$advertisement['rerConstraints'];
        $this->creation_date =$advertisement['creationDate'];
        $this->end_date =$advertisement['endDate'];
        $this->area=$advertisement['propertyArea'];



    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }


    protected function findOrCreateTranslatable(string $model, string $field, string $value, array $extra = []): mixed
    {
        $record = $model::whereTranslation($field, $value)->first();

        if (!$record) {
            $en = Str::title(str_replace('-', ' ', Str::slug($value)));
            $record = new $model($extra);
            $record->save();

            $record->translateOrNew('ar')->$field = $value;
            $record->translateOrNew('en')->$field = $en;
            $record->save();
        }

        return [
            "id" => $record->id,
            "name" => $record->$field,
        ];
    }

}
