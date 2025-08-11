<?php

namespace App\Component\Properties\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use App\Component\Properties\Domain\Enum\ServiceTypeEnum;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "UpdateServiceRequest",
    description: "Request for updating an existing service",
    properties: [
        new OA\Property(property: "type", type: "string", description: "Type of service (real_estate_services or support_services)"),
        new OA\Property(property: "name", type: "string", maxLength: 255, description: "Name of the service"),
        new OA\Property(property: "is_active", type: "boolean", description: "Whether the service is active"),
    ],
    type: "object",
)]
class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['sometimes', 'string', 'in:' . implode(',', ServiceTypeEnum::values())],
            'name' => ['sometimes', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.in' => 'Service type must be either Real Estate Services or Support Services.',
            'name.max' => 'Service name cannot exceed 255 characters.',
        ];
    }
}
