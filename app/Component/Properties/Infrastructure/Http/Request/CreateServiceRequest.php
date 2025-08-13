<?php

namespace App\Component\Properties\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use App\Component\Properties\Domain\Enum\ServiceTypeEnum;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "CreateServiceRequest",
    description: "Request for creating a new service",
    required: ["type", "name"],
    properties: [
        new OA\Property(property: "type", type: "string", description: "Type of service (real_estate_services or support_services)"),
        new OA\Property(property: "name", type: "string", maxLength: 255, description: "Name of the service"),
        new OA\Property(property: "is_active", type: "boolean", default: true, description: "Whether the service is active"),
        new OA\Property(
            property: 'image',
            description: 'Service image.',

        ),
    ],
    type: "object",
)]
class CreateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:' . implode(',', ServiceTypeEnum::values())],
            'name' => ['required', 'string', 'max:255'],
            'image' => [
                'nullable',
                'max:5120', // 5MB
                'mimetypes:image/jpeg,image/png,image/gif,image/svg+xml,image/webp,image/bmp,image/tiff',
            ],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Service type is required.',
            'type.in' => 'Service type must be either Real Estate Services or Support Services.',
            'name.required' => 'Service name is required.',
            'name.max' => 'Service name cannot exceed 255 characters.',
        ];
    }
}
