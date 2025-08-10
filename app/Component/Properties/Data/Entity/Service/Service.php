<?php

namespace App\Component\Properties\Data\Entity\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Component\Properties\Domain\Enum\ServiceTypeEnum;

class Service extends Model
{
    use HasFactory;

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
