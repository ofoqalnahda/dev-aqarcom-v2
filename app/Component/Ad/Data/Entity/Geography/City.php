<?php

namespace App\Component\Ad\Data\Entity\Geography;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model implements TranslatableContract
{
    use HasFactory ,Translatable ;
    protected $guarded = [];
    public array $translatedAttributes = ['name'];

    protected $with = ['translation'];

    public function region()
    {
        return $this->belongsTo(Region::class , 'region_id');
    }
    public function neighborhoods()
    {
        return $this->hasMany(Neighborhood::class , 'city_id');
    }


}
