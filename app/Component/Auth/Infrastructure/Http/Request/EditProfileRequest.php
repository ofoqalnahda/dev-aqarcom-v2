<?php

namespace App\Component\Auth\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'EditProfileRequest',
    required: true,
    content: new OA\JsonContent(
        properties: [
            new OA\Property(property: 'name', type: 'string', nullable: true),
            new OA\Property(property: 'email', type: 'string', nullable: true),
            new OA\Property(property: 'whatsapp', type: 'string', nullable: true),
            new OA\Property(property: 'commercial_name', type: 'string', nullable: true),
            new OA\Property(property: 'location', type: 'object', nullable: true, properties: [
                new OA\Property(property: 'latitude', type: 'number', format: 'float', nullable: true),
                new OA\Property(property: 'longitude', type: 'number', format: 'float', nullable: true),
                new OA\Property(property: 'address', type: 'string', nullable: true),
            ]),
            new OA\Property(property: 'about_company', type: 'string', nullable: true, description: 'Company description'),
            new OA\Property(property: 'working_hours', type: 'array', nullable: true, items: new OA\Items(
                type: 'object',
                properties: [
                    new OA\Property(property: 'day', type: 'string', enum: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']),
                    new OA\Property(property: 'start_time', type: 'string', format: 'time', nullable: true),
                    new OA\Property(property: 'end_time', type: 'string', format: 'time', nullable: true),
                    new OA\Property(property: 'is_working_day', type: 'boolean', default: true),
                ]
            )),
            new OA\Property(property: 'previous_work_history', type: 'array', nullable: true, items: new OA\Items(
                type: 'object',
                properties: [
                    new OA\Property(property: 'company_name', type: 'string'),
                    new OA\Property(property: 'description', type: 'string'),
                    new OA\Property(property: 'start_date', type: 'string', format: 'date', nullable: true),
                    new OA\Property(property: 'end_date', type: 'string', format: 'date', nullable: true),
                    new OA\Property(property: 'is_current_job', type: 'boolean', default: false),
                ]
            )),
            new OA\Property(property: 'services', type: 'array', nullable: true, items: new OA\Items(type: 'integer'), description: 'Array of service IDs'),
        ],
    )
)]
class EditProfileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'whatsapp' => ['nullable', 'string'],
            'commercial_name' => ['nullable', 'string'],
            'location' => ['nullable', 'array'],
            'location.latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'location.longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'location.address' => ['nullable', 'string'],
            'about_company' => ['nullable', 'string', 'max:1000'],
            'working_hours' => ['nullable', 'array'],
            'working_hours.*.day' => ['required_with:working_hours', 'string', 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
            'working_hours.*.start_time' => ['nullable', 'date_format:H:i'],
            'working_hours.*.end_time' => ['nullable', 'date_format:H:i'],
            'working_hours.*.is_working_day' => ['nullable', 'boolean'],
            'previous_work_history' => ['nullable', 'array'],
            'previous_work_history.*.company_name' => ['required_with:previous_work_history', 'string', 'max:255'],
            'previous_work_history.*.description' => ['required_with:previous_work_history', 'string', 'max:1000'],
            'previous_work_history.*.start_date' => ['nullable', 'date'],
            'previous_work_history.*.end_date' => ['nullable', 'date', 'after_or_equal:previous_work_history.*.start_date'],
            'previous_work_history.*.is_current_job' => ['nullable', 'boolean'],
            'services' => ['nullable', 'array'],
            'services.*' => ['integer', 'exists:services,id'],
        ];
    }
} 