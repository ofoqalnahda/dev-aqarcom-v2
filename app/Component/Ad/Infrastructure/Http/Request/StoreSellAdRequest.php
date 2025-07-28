<?php

namespace App\Component\Ad\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'StoreSellAdRequest',
    required: true,
    content: new OA\JsonContent(
        required: ['license_number', 'is_special', 'is_story', 'description','main_image'],
        properties: [
            new OA\Property(
                property: 'license_number',
                description: 'The license number must be exactly 10 digits long and must begin with 72.',
                type: 'string',
                maxLength: 10,
                minLength: 10,
                pattern: '^72\d{8}$'
            ),
            new OA\Property(
                property: 'is_special',
                description: 'Is the ad marked as special?',
                type: 'boolean'
            ),
            new OA\Property(
                property: 'is_story',
                description: 'Is the ad shown as a story?',
                type: 'boolean'
            ),
            new OA\Property(
                property: 'description',
                description: 'Ad description text.',
                type: 'string'
            ),
            new OA\Property(
                property: 'main_image',
                description: 'Ad main image.',

            ),
            new OA\Property(
                property: 'images',
                description: 'Array of image files. Each image must be one of: jpeg, png, gif, svg, webp, bmp, tiff and max 5MB each.',
                type: 'array',
                items: new OA\Items(type: 'string', format: 'binary')
            ),
            new OA\Property(
                property: 'video',
                description: 'Video file (mp4, avi, mpeg, mov). Max size: 50MB.',
                format: 'binary'
            ),
        ]
    )
)]
class StoreSellAdRequest extends FormRequest
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
            'is_special' => [
                'required',
                'boolean',
            ],
            'is_story' => [
                'required',
                'boolean',
            ],
            'description' => [
                'required',
                'string',
            ],
            'main_image' => [
                'required',
                'max:5120', // 5MB
                'mimetypes:image/jpeg,image/png,image/gif,image/svg+xml,image/webp,image/bmp,image/tiff',
            ],
            'images' => [
                'nullable',
                'array',
            ],

            'images.*' => [
                'nullable',
                'max:5120', // 5MB
                'mimetypes:image/jpeg,image/png,image/gif,image/svg+xml,image/webp,image/bmp,image/tiff',
            ],
            'video' => [
                'nullable',
                'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime,video/x-msvideo',
                'max:51200', // 50MB
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
