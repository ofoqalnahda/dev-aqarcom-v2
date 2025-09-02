<?php

namespace App\Component\Auth\Data\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'rating',
        'description'
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'company_id');
    }
}


