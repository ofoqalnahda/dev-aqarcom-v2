<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Component\Ad\Data\Entity\Ad\Ad;
use App\Models\WorkingHour;
use App\Models\PreviousWorkHistory;
use App\Component\Auth\Data\Entity\Rating;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasApiTokens;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [  ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function favoriteAds()
    {
        return $this->belongsToMany(Ad::class, 'favorites', 'user_id', 'ad_id')->withTimestamps();
    }
    public function viewAds()
    {
        return $this->belongsToMany(Ad::class, 'ad_user_views', 'user_id', 'ad_id')->withTimestamps();
    }
    public function ads()
    {
        return $this->hasMany(Ad::class, 'user_id');
    }

    public function workingHours()
    {
        return $this->hasMany(WorkingHour::class);
    }

    public function previousWorkHistory()
    {
        return $this->hasMany(PreviousWorkHistory::class);
    }

    public function services()
    {
        return $this->belongsToMany(\App\Component\Properties\Data\Entity\Service\Service::class, 'user_services', 'user_id', 'service_id')->withTimestamps();
    }

    public function ratingsGiven()
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    public function ratingsReceived()
    {
        return $this->hasMany(Rating::class, 'company_id');
    }

    /**
     * Get the average rating received by this user/company
     */
    public function getAverageRatingAttribute()
    {
        return $this->ratingsReceived()->avg('rating') ?? 0.0;
    }

    /**
     * Get the total count of ratings received
     */
    public function getRatingCountAttribute()
    {
        return $this->ratingsReceived()->count();
    }

    /**
     * Get the total count of ratings given by this user
     */
    public function getRatingsGivenCountAttribute()
    {
        return $this->ratingsGiven()->count();
    }

    /**
     * Check if user has rated a specific company
     */
    public function hasRatedCompany(int $companyId): bool
    {
        return $this->ratingsGiven()->where('company_id', $companyId)->exists();
    }

    /**
     * Get user's rating for a specific company
     */
    public function getRatingForCompany(int $companyId): ?Rating
    {
        return $this->ratingsGiven()->where('company_id', $companyId)->first();
    }
}
