<?php

namespace App\Component\Auth\Infrastructure\Http\Handler;

use App\Component\Auth\Infrastructure\ViewQuery\RatingViewQuery;
use App\Libraries\Base\Http\Handler;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/auth/companies/{companyId}/ratings',
    tags: ['Auth'],
    responses: [
        new OA\Response(response: 200, description: 'Company ratings retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'success'),
                new OA\Property(property: 'message', type: 'string', example: 'Company ratings retrieved successfully'),
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/RatingViewModel')),
                new OA\Property(property: 'meta', type: 'object'),
            ],
            type: 'object'
        )),
        new OA\Response(response: 404, description: 'Company not found', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'error'),
                new OA\Property(property: 'message', type: 'string', example: 'Company not found'),
            ],
            type: 'object'
        )),
    ]
)]
class GetCompanyRatingsHandler extends Handler
{
    public function __construct(
        private RatingViewQuery $ratingViewQuery
    ) {}

    public function __invoke(int $companyId): \Illuminate\Http\JsonResponse
    {
        try {
            $perPage = request()->get('per_page', 15);
            $ratings = $this->ratingViewQuery->getCompanyRatings($companyId, $perPage);

            $ratingViewModels = $ratings->map(function ($rating) {
                return (new \App\Component\Auth\Presentation\ViewModel\RatingViewModel($rating))->toArray();
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Company ratings retrieved successfully',
                'data' => $ratingViewModels,
                'meta' => [
                    'current_page' => $ratings->currentPage(),
                    'last_page' => $ratings->lastPage(),
                    'per_page' => $ratings->perPage(),
                    'total' => $ratings->total(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}


