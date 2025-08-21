<?php

namespace App\Component\Auth\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
use App\Component\Auth\Domain\Enum\UserTypeEnum;
use Illuminate\Validation\Rule;

#[OA\RequestBody(
    request: 'CompleteProfileRequest',
    required: true,
    content: new OA\JsonContent(
        required: ['name', 'identity_number', 'account_type'],
        properties: [
            new OA\Property(property: 'name', type: 'string'),
            new OA\Property(property: 'identity_number', type: 'string'),
            new OA\Property(property: 'email', type: 'string', nullable: true),
            new OA\Property(property: 'account_type', type: 'string', enum: ['individual', 'office', 'organization', 'support_facility']),
            new OA\Property(property: 'commercial_name', type: 'string', nullable: true),
            new OA\Property(property: 'commercial_number', type: 'string', nullable: true),
        ],
    )
)]
class CompleteProfileRequest extends FormRequest
{
    public function rules()
    {
        $accountTypes = array_map(fn($case) => $case->value, UserTypeEnum::cases());
        return [
            'name' => ['required', 'string'],
            'identity_number' => ['required', 'string'],
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore(auth()->guard('api')->id()),
            ],
            'account_type' => ['required', 'string', 'in:' . implode(',', $accountTypes)],
            'commercial_name' => ['required_if:account_type,office,organization', 'nullable', 'string'],
            'commercial_number' => ['required_if:account_type,office,organization', 'nullable', 'string'],
        ];
    }
}
