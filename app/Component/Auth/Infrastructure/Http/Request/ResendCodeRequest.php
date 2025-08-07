<?php

namespace App\Component\Auth\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'ResendCodeRequest',
    required: true,
    content: new OA\JsonContent(
        required: ['user_id'],
        properties: [
            new OA\Property(property: 'user_id', description: 'Id For User ', type: 'integer'),
        ],
    )
)]
class ResendCodeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => ['required','exists:users,id'],
        ];
    }
}
