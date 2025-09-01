<?php

namespace App\Component\Auth\Infrastructure\Http\Handler;

use App\Component\Auth\Application\Service\RatingServiceInterface;
use App\Component\Auth\Infrastructure\ViewQuery\RatingViewQuery;
use App\Libraries\Base\Http\Handler;
use OpenApi\Attributes as OA;

#[OA\Delete(
    path: '/api/v1/auth/ratings/{id}',
    security: [['sanctum' => []]],
    tags: ['Auth'],
    responses: [
        new OA\Response(response: 200, description: 'Rating deleted successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'success'),
                new OA\Property(property: 'message', type: 'string', example: 'Rating deleted successfully'),
            ],
            type: 'object'
        )),
        new OA\Response(response: 404, description: 'Rating not found', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'error'),
                new OA\Property(property: 'message', type: 'string', example: 'Rating not found'),
            ],
            type: 'object'
        )),
        new OA\Response(response: 422, description: 'Business logic error', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'error'),
                new OA\Property(property: 'message', type: 'string'),
            ],
            type: 'object'
        )),
    ]
)]
class DeleteRatingHandler extends Handler
{
    public function __construct(
        private RatingServiceInterface $ratingService,
        private RatingViewQuery $ratingViewQuery
    ) {}

    public function __invoke(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $rating = $this->ratingViewQuery->findById($id);
            if (!$rating) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Rating not found',
                ], 404);
            }

            $deleted = $this->ratingService->deleteRating($id);
            
            if (!$deleted) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to delete rating',
                ], 422);
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'Rating deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}



