<?php

namespace App\Component\Ad\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;


#[OA\RequestBody(
    request: 'StoreBuyAdRequest',
    required: true,
    content: new OA\JsonContent(
        required: ['description', 'ad_type_id', 'estate_type_id', 'region_id', 'city_id', 'neighborhood_id'],
        properties: [
            new OA\Property(
                property: 'ad_type_id',
                description: 'Type of the ad',
                type: 'integer',
                example: 1
            ),
            new OA\Property(
                property: 'estate_type_id',
                description: 'Type of the estate',
                type: 'integer',
                example: 2
            ),
            new OA\Property(
                property: 'region_id',
                description: 'ID of the region',
                type: 'integer',
                example: 3
            ),
            new OA\Property(
                property: 'city_id',
                description: 'ID of the city',
                type: 'integer',
                example: 4
            ),
            new OA\Property(
                property: 'neighborhood_id',
                description: 'ID of the neighborhood',
                type: 'integer',
                example: 5
            ),
            new OA\Property(
                property: 'price',
                description: 'Ad price',
                type: 'number',
                format: 'float',
                example: 150000
            ),
            new OA\Property(
                property: 'description',
                description: 'Ad description text.',
                type: 'string',
                example: 'This is a description of the ad.'
            ),

        ]
    )
)]
class StoreBuyAdRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'ad_type_id' => [
                'required',
                'integer',
                'exists:ad_types,id',
            ],
            'estate_type_id' => [
                'required',
                'integer',
                'exists:estate_types,id',
            ],
            'region_id' => [
                'required',
                'integer',
                'exists:regions,id',
            ],
            'city_id' => [
                'required',
                'integer',
                'exists:cities,id',
            ],
            'neighborhood_id' => [
                'required',
                'integer',
                'exists:neighborhoods,id',
            ],
            'price'=>[
              'nullable',
              'numeric'
            ],
            'description' => [
                'required',
                'string',
            ],

        ];
    }

    public function messages(): array
    {
        return [
            'ad_type_id.required'       => translate('Ad type is required.'),
            'ad_type_id.exists'         => translate('Selected ad type does not exist.'),

            'estate_type.required'      => translate('Estate type is required.'),
            'estate_type.exists'        => translate('Selected estate type does not exist.'),

            'region_id.required'        => translate('Region is required.'),
            'region_id.exists'          => translate('Selected region does not exist.'),

            'city_id.required'          => translate('City is required.'),
            'city_id.exists'            => translate('Selected city does not exist.'),

            'neighborhood_id.required'  => translate('Neighborhood is required.'),
            'neighborhood_id.exists'    => translate('Selected neighborhood does not exist.'),

            'description.required'      => translate('Description is required.'),
        ];

    }
}
