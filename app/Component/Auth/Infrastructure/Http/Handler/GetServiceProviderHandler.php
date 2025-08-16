<?php

namespace App\Component\Auth\Infrastructure\Http\Handler;

use App\Component\Auth\Application\Mapper\UserMapperInterface;
use App\Component\Auth\Infrastructure\ViewQuery\UserViewQuery;
use App\Component\Auth\Presentation\ViewModel\UserViewModel;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/service-providers/{id}',
    tags: ['Service Providers'],
    parameters: [
        new OA\Parameter(
            name: 'id',
            description: 'Service provider ID',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'integer', example: 1)
        ),
        new OA\Parameter(
            name: 'latitude',
            description: 'User latitude for distance calculation',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'number', format: 'float', example: 21.422510)
        ),
        new OA\Parameter(
            name: 'longitude',
            description: 'User longitude for distance calculation',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'number', format: 'float', example: 39.826168)
        ),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Success',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'status', type: 'string', example: 'success'),
                    new OA\Property(property: 'message', type: 'string', example: 'Service provider retrieved successfully'),
                    new OA\Property(property: 'data', ref: '#/components/schemas/UserViewModel'),
                ],
                type: 'object'
            )
        ),
        new OA\Response(response: 404, description: 'Service provider not found'),
        new OA\Response(response: 400, description: 'Bad Request - User is individual, not service provider'),
        new OA\Response(response: 500, description: 'Internal Server Error'),
    ]
)]
class GetServiceProviderHandler extends Handler
{
    public function __construct(
        private UserMapperInterface $userMapper,
        private UserViewQuery $userViewQuery
    ) {
    }

    public function __invoke(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $userLat = $request->input('latitude');
            $userLng = $request->input('longitude');
            
            // Get service provider with distance calculation
            $user = $this->userViewQuery->findServiceProvider(
                $id, 
                $userLat ? (float) $userLat : null, 
                $userLng ? (float) $userLng : null
            );

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Service provider not found'
                ], 404);
            }

            $viewModel = $this->userMapper->toViewModel($user);

            return response()->json([
                'status' => 'success',
                'message' => 'Service provider retrieved successfully',
                'data' => $viewModel->toArray(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve service provider',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
