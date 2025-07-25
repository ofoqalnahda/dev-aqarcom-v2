<?php

namespace App\Component\Settings\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'CreateWithdrawalRequest',
    required: true,
    content: new OA\JsonContent(
        required: ['account_number', 'account_holder_name', 'amount'],
        properties: [
            new OA\Property(property: 'account_number', description: 'Bank account number', type: 'string'),
            new OA\Property(property: 'account_holder_name', description: 'Account holder name', type: 'string'),
            new OA\Property(property: 'amount', description: 'Withdrawal amount', type: 'number', format: 'decimal'),
        ],
    )
)]
class CreateWithdrawalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'account_number' => [
                'required',
                'string',
                'max:50',
            ],
            'account_holder_name' => [
                'required',
                'string',
                'max:255',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:1',
                'max:999999.99',
            ],
        ];
    }
} 