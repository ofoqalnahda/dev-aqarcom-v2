<?php

namespace App\Component\Auth\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'EditProfileRequest',
    required: true,
    content: new OA\JsonContent(
        properties: [
            new OA\Property(property: 'name', type: 'string', nullable: true),
            new OA\Property(property: 'email', type: 'string', nullable: true),
            new OA\Property(property: 'whatsapp', type: 'string', nullable: true),
            new OA\Property(property: 'commercial_name', type: 'string', nullable: true),
            new OA\Property(property: 'location', type: 'object', nullable: true, properties: [
                new OA\Property(property: 'latitude', type: 'number', format: 'float', nullable: true),
                new OA\Property(property: 'longitude', type: 'number', format: 'float', nullable: true),
                new OA\Property(property: 'address', type: 'string', nullable: true),
            ]),
        ],
    )
)]
class EditProfileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'whatsapp' => ['nullable', 'string'],
            'commercial_name' => ['nullable', 'string'],
            'location' => ['nullable', 'array'],
            'location.latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'location.longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'location.address' => ['nullable', 'string'],
        ];
    }
} 