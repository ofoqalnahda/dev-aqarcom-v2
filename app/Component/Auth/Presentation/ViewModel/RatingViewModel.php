<?php

namespace App\Component\Auth\Presentation\ViewModel;

use App\Component\Auth\Data\Entity\Rating;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'RatingViewModel',
    title: 'Rating View Model',
    description: 'Rating data for API responses'
)]
class RatingViewModel
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public $id;

    #[OA\Property(property: 'user_id', type: 'integer', example: 1)]
    public $user_id;

    #[OA\Property(property: 'company_id', type: 'integer', example: 2)]
    public $company_id;

    #[OA\Property(property: 'rating', type: 'integer', minimum: 1, maximum: 5, example: 5)]
    public $rating;

    #[OA\Property(property: 'description', type: 'string', nullable: true, example: 'Great service!')]
    public $description;

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time')]
    public $created_at;

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time')]
    public $updated_at;

    #[OA\Property(property: 'user', ref: '#/components/schemas/UserViewModel')]
    public $user;

    #[OA\Property(property: 'company', ref: '#/components/schemas/UserViewModel')]
    public $company;

    public function __construct(Rating $rating)
    {
        $this->id = $rating->id;
        $this->user_id = $rating->user_id;
        $this->company_id = $rating->company_id;
        $this->rating = $rating->rating;
        $this->description = $rating->description;
        $this->created_at = $rating->created_at;
        $this->updated_at = $rating->updated_at;

        if ($rating->relationLoaded('user')) {
            $this->user = $rating->user;
        }

        if ($rating->relationLoaded('company')) {
            $this->company = $rating->company;
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
            'rating' => $this->rating,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => $this->user,
            'company' => $this->company,
        ];
    }
}


