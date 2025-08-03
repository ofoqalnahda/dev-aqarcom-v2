<?php

namespace App\Component\Settings\Data\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'user_id',
        'is_public',
        'description',
    ];

    protected $casts = [
        'value' => 'array',
        'is_public' => 'boolean',
    ];
} 