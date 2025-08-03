<?php

namespace App\Component\Settings\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'CreateContactRequest',
    required: true,
    content: new OA\JsonContent(
        required: ['name', 'email', 'mobile', 'subject', 'message'],
        properties: [
            new OA\Property(property: 'name', description: 'Contact person name', type: 'string'),
            new OA\Property(property: 'email', description: 'Contact email address', type: 'string', format: 'email'),
            new OA\Property(property: 'mobile', description: 'Contact mobile number', type: 'string'),
            new OA\Property(property: 'subject', description: 'Message subject', type: 'string'),
            new OA\Property(property: 'message', description: 'Message content', type: 'string'),
        ],
    )
)]
class CreateContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'mobile' => [
                'required',
                'string',
                'max:20',
            ],
            'subject' => [
                'required',
                'string',
                'max:255',
            ],
            'message' => [
                'required',
                'string',
                'max:2000',
            ],
        ];
    }
} 