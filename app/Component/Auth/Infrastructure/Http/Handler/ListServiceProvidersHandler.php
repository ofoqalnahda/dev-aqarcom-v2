<?php

namespace App\Component\Auth\Infrastructure\Http\Handler;

use App\Component\Auth\Presentation\ViewModel\UserViewListModel;
use App\Libraries\Base\Http\Handler;
use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/service-providers',
    tags: ['Service Providers'],
    parameters: [
        new OA\Parameter(
            name: 'search',
            description: 'Search by company name',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'string', example: 'construction')
        ),
        new OA\Parameter(
            name: 'per_page',
            description: 'Number of items per page',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer', default: 15, example: 20)
        ),
        new OA\Parameter(
            name: 'page',
            description: 'Page number',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer', default: 1, example: 2)
        ),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Success',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'status', type: 'string', example: 'success'),
                    new OA\Property(property: 'message', type: 'string', example: 'Service providers retrieved successfully'),
                    new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/UserViewListModel')),
                    new OA\Property(property: 'pagination', type: 'object', properties: [
                        new OA\Property(property: 'current_page', type: 'integer', example: 1),
                        new OA\Property(property: 'last_page', type: 'integer', example: 5),
                        new OA\Property(property: 'per_page', type: 'integer', example: 15),
                        new OA\Property(property: 'total', type: 'integer', example: 75),
                    ]),
                ],
                type: 'object'
            )
        ),
        new OA\Response(response: 400, description: 'Bad Request'),
        new OA\Response(response: 500, description: 'Internal Server Error'),
    ]
)]
class ListServiceProvidersHandler extends Handler
{
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $query = User::query()
                ->where('user_type', '!=', 'individual')
                ->withAvg('ratingsReceived', 'rating')
                ->withCount('ratingsReceived');

            // Apply search filter
            if ($search = $request->input('search')) {
                $query->where('name', 'like', "%{$search}%");
            }

            // Get paginated results
            $perPage = $request->input('per_page', 15);
            $users = $query->orderBy('name')->paginate($perPage);

            // Transform to view models
            $data = $users->getCollection()->map(function ($user) {
                return new UserViewListModel($user);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Service providers retrieved successfully',
                'data' => $data,
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve service providers',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
