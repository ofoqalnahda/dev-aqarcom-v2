<?php

namespace App\Component\Properties\Data\Entity\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Component\Properties\Domain\Enum\ServiceTypeEnum;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'type',
        'name',
        'is_active'
    ];

    protected $casts = [
        'type' => ServiceTypeEnum::class,
        'is_active' => 'boolean'
    ];

    protected $table = 'services';
}



