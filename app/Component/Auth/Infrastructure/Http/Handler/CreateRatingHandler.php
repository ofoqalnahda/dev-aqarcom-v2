<?php

namespace App\Component\Auth\Infrastructure\Http\Handler;

use App\Component\Auth\Infrastructure\Http\Request\CreateRatingRequest;
use App\Component\Auth\Application\Service\RatingServiceInterface;
use App\Component\Auth\Presentation\ViewModel\RatingViewModel;
use App\Libraries\Base\Http\Handler;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/auth/ratings',
    security: [['sanctum' => []]],
    requestBody: new OA\RequestBody(ref: '#/components/requestBodies/CreateRatingRequest'),
    tags: ['Auth'],
    responses: [
        new OA\Response(response: 201, description: 'Rating created successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'success'),
                new OA\Property(property: 'message', type: 'string', example: 'Rating created successfully'),
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
        new OA\Response(response: 422, description: 'Business logic error', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string', example: 'error'),
                new OA\Property(property: 'message', type: 'string'),
            ],
            type: 'object'
        )),
    ]
)]
class CreateRatingHandler extends Handler
{
    public function __construct(
        private RatingServiceInterface $ratingService
    ) {}

    public function __invoke(CreateRatingRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();

            $rating = $this->ratingService->createRating($data);
            $ratingViewModel = new RatingViewModel($rating);

            return response()->json([
                'status' => 'success',
                'message' => 'Rating created successfully',
                'data' => $ratingViewModel->toArray(),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}


