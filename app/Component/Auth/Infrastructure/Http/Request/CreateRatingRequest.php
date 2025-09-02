<?php

namespace App\Component\Auth\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'CreateRatingRequest',
    required: true,
    content: new OA\JsonContent(
        properties: [
            new OA\Property(property: 'company_id', type: 'integer', example: 2),
            new OA\Property(property: 'rating', type: 'integer', minimum: 1, maximum: 5, example: 5),
            new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Great service!'),
        ],
        required: ['company_id', 'rating']
    )
)]
class CreateRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => ['required', 'integer', 'exists:users,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'company_id.required' => 'Company ID is required',
            'company_id.exists' => 'Company not found',
            'rating.required' => 'Rating is required',
            'rating.min' => 'Rating must be at least 1',
            'rating.max' => 'Rating cannot exceed 5',
            'description.max' => 'Description cannot exceed 1000 characters',
        ];
    }
}



