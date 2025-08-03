<?php

namespace App\Component\Settings\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'UpdateSettingRequest',
    required: true,
    content: new OA\JsonContent(
        required: ['key', 'value'],
        properties: [
            new OA\Property(property: 'key', description: 'Setting key', type: 'string'),
            new OA\Property(property: 'value', description: 'Setting value', type: 'object'),
            new OA\Property(property: 'type', description: 'Setting type', type: 'string', nullable: true),
            new OA\Property(property: 'description', description: 'Setting description', type: 'string', nullable: true),
        ],
    )
)]
class UpdateSettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'key' => [
                'required',
                'string',
                'max:255',
            ],
            'value' => [
                'required',
            ],
            'type' => [
                'nullable',
                'string',
                'max:50',
            ],
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }
} 