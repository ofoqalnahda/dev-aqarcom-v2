<?php

namespace App\Component\Ad\Data\Entity\Ad;

use App\Component\Ad\Data\Entity\Geography\City;
use App\Component\Ad\Data\Entity\Geography\Neighborhood;
use App\Component\Ad\Data\Entity\Geography\Region;
use App\Component\Auth\Data\Entity\User\User;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'id',
        'license_number',
        'user_id',
        'ad_type_id',

        'region_id',
        'city_id',
        'neighborhood_id',
        'estate_type_id',
        'usage_type_id',
        'main_type',
        'status',
        'is_special',
        'is_story',
        'address',
        'lng',
        'lat',
        'price',
        'property_price',
        'area',
        'description',
        "is_constrained",
        "is_pawned",
        "is_halted",
        "is_testament",

        'street_width',
        'number_of_rooms',
        'deed_number',
        'property_face',
        'plan_number',
        'land_number',
        'ad_license_url',
        'ad_source',
        'title_deed_type_name',
        'location_description',
        'property_age',
        'property_age',
        'rer_constraints',
        'creation_date',
        'end_date',

        'refresh_date',
        'cancelled_at',
        'reason_id',
    ];

    protected $table = 'ads';

    protected $casts = [
        'rer_constraints' => 'array',
        'status' => 'boolean',
        'is_special' => 'boolean',
        'is_story' => 'boolean',
        'is_constrained' => 'boolean',
        'is_pawned' => 'boolean',
        'is_halted' => 'boolean',
        'is_testament' => 'boolean',
        'creation_date' => 'date',
        'end_date' => 'date',
    ];

    // relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function ad_type()
    {
        return $this->belongsTo(AdType::class);
    }
    public function estateType()
    {
        return $this->belongsTo(EstateType::class);
    }

    public function usageType()
    {
        return $this->belongsTo(UsageType::class);
    }

    public function reason_cancelled()
    {
        return $this->belongsTo(Reason::class, 'reason_id');
    }
    public function propertyUtilities()
    {
        return $this->belongsToMany(PropertyUtility::class, 'ad_property_utility');
    }

}
