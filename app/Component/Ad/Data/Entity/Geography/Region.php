<?php

namespace App\Component\Ad\Data\Entity\Geography;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model implements TranslatableContract
{
    use HasFactory ,Translatable ;
    protected $guarded = [];
    public $translatedAttributes = ['name'];

    protected $with = ['translation'];


    public function cities()
    {
        return $this->hasMany(City::class , 'region_id');
    }
    public function region_map()
    {
        return $this->belongsTo(RegionMap::class , 'region_map_id');
    }
}
