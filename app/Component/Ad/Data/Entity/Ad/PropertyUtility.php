<?php

namespace App\Component\Ad\Data\Entity\Ad;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Model;

class PropertyUtility extends Model  implements TranslatableContract
{
    use HasFactory, Translatable;

    public array $translatedAttributes = ['title'];

    protected $guarded = [];
}
