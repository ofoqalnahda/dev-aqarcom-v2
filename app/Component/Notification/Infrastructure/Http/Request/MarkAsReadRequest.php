<?php

namespace App\Component\Notification\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class MarkAsReadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'notification_id' => 'sometimes|integer|exists:notifications,id'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'notification_id.exists' => 'The notification does not exist.'
        ];
    }
}
