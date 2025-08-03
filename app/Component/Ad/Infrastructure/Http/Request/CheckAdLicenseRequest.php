<?php

namespace App\Component\Ad\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'CheckAdLicenseRequest',
    required: true,
    content: new OA\JsonContent(
        required: ['license_number'],
        properties: [
            new OA\Property(
                property: 'license_number',
                description: 'The license number must be exactly 10 digits long and must begin with 72.',
                type: 'string',
                maxLength: 10,
                minLength: 10,
                pattern: '^72\d{8}$'
            ),
        ],
    )
)]
class CheckAdLicenseRequest extends FormRequest
{
    public int|string $license_number;

    public function rules(): array
    {
        return [
            'license_number' => [
                'required',
                'string',
                'regex:/^72\d{8}$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'license_number.regex' => __('validation.custom.license_number.regex'),
        ];
    }
}
