<?php

namespace App\Component\Auth\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'LoginRequest',
    required: true,
    content: new OA\JsonContent(
        required: ['phone'],
        properties: [
            new OA\Property(property: 'phone', description: 'Phone number', type: 'string'),
        ],
    )
)]
class LoginRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                'regex:/^\d+$/',
            ]
        ];
    }

}
