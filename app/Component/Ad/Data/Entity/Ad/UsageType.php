<?php

namespace App\Component\Ad\Data\Entity\Ad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class UsageType extends Model implements TranslatableContract
{
    use HasFactory ,Translatable ;
    protected $guarded = [];
    public $translatedAttributes = ['title'];

    protected $with = ['translation'];

}
