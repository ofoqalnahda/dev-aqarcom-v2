<?php

namespace App\Component\Auth\Infrastructure\Http\Handler;

use App\Component\Auth\Infrastructure\Http\Request\UpdateRatingRequest;
use App\Component\Auth\Application\Service\RatingServiceInterface;
use App\Component\Auth\Infrastructure\ViewQuery\RatingViewQuery;
use App\Component\Auth\Presentation\ViewModel\RatingViewModel;
use App\Libraries\Base\Http\Handler;
use OpenApi\Attributes as OA;

#[OA\Put(
    path: '/api/v1/auth/ratings/{id}',
    security: [['sanctum' => []]],
    requestBody: new OA\RequestBody(ref: '#/components/requestBodies/UpdateRatingRequest'),
    tags: ['Auth'],
    responses: [
        new OA\Response(response: 200, description: 'Rating updated successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'success'),
                new OA\Property(property: 'message', type: 'string', example: 'Rating updated successfully'),
                new OA\Property(property: 'data', ref: '#/components/schemas/RatingViewModel'),
            ],
            type: 'object'
        )),
        new OA\Response(response: 400, description: 'Validation error', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'error'),
                new OA\Property(property: 'message', type: 'string'),
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
class UpdateRatingHandler extends Handler
{
    public function __construct(
        private RatingServiceInterface $ratingService,
        private RatingViewQuery $ratingViewQuery
    ) {}

    public function __invoke(UpdateRatingRequest $request, int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $rating = $this->ratingViewQuery->findById($id);
            if (!$rating) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Rating not found',
                ], 404);
            }

            $data = $request->validated();
            $updated = $this->ratingService->updateRating($id, $data);
            
            if (!$updated) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update rating',
                ], 422);
            }

            $rating->refresh();
            $ratingViewModel = new RatingViewModel($rating);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Rating updated successfully',
                'data' => $ratingViewModel->toArray(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}



