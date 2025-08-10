<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreviousWorkHistory extends Model
{
    use HasFactory;

    protected $table = 'previous_work_history';

    protected $fillable = [
        'user_id',
        'company_name',
        'description',
        'start_date',
        'end_date',
        'is_current_job'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current_job' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
