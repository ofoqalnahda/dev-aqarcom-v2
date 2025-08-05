<?php

namespace App\Component\Auth\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'VerifyCodeRequest',
    required: true,
    content: new OA\JsonContent(
        required: ['code'],
        properties: [
            new OA\Property(property: 'user_id', description: 'User ID', type: 'integer'),
            new OA\Property(property: 'code', description: 'Verification code', type: 'string'),
        ],
    )
)]
class VerifyCodeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'code' => ['required', 'string', 'size:4', 'regex:/^[0-9]{4}$/'],
        ];
    }

    public function userId()
    {
        return $this->input('user_id');

    }

    public function code()
    {
        return $this->input('code');
    }
}
