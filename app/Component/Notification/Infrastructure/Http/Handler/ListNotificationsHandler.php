<?php

namespace App\Component\Notification\Infrastructure\Http\Handler;

use App\Component\Notification\Application\Mapper\NotificationMapperInterface;
use App\Component\Notification\Application\Service\NotificationServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/notifications',
    operationId: "List Notifications",
    summary: "List user notifications",
    security: [['sanctum' => []]],
    tags: ['Notifications'],
    parameters: [
        new OA\Parameter(name: "is_read", in: "query", required: false, schema: new OA\Schema(type: "boolean")),
        new OA\Parameter(name: "search", in: "query", required: false, schema: new OA\Schema(type: "string")),
        new OA\Parameter(name: "per_page", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "page", in: "query", required: false, schema: new OA\Schema(type: "integer")),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Success',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'status', type: 'string'),
                    new OA\Property(property: 'message', type: 'string'),
                    new OA\Property(
                        property: 'data',
                        properties: [
                            new OA\Property(
                                property: 'items',
                                type: 'array',
                                items: new OA\Items(ref: '#/components/schemas/NotificationViewModel')
                            ),
                            new OA\Property(
                                property: 'meta',
                                properties: [
                                    new OA\Property(property: 'current_page', type: 'integer'),
                                    new OA\Property(property: 'per_page', type: 'integer'),
                                    new OA\Property(property: 'total', type: 'integer'),
                                    new OA\Property(property: 'last_page', type: 'integer'),
                                ],
                                type: 'object'
                            ),
                        ],
                        type: 'object'
                    ),
                ],
                type: 'object'
            )
        ),
        new OA\Response(response: 401, description: 'Unauthorized'),
        new OA\Response(response: 500, description: 'Server Error'),
    ],
)]
class ListNotificationsHandler extends Handler
{
    public function __construct(
        private NotificationServiceInterface $notificationService,
        private NotificationMapperInterface $notificationMapper
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return responseApiFalse(401, 'Unauthorized');
            }

            $filters = $request->only(['is_read', 'search', 'per_page', 'page']);
            
            $notifications = $this->notificationService->list($user, $filters);
            
            $viewModels = $this->notificationMapper->toViewModels($notifications->items());

            return responseApi('Notifications retrieved successfully', [
                'items' => $viewModels,
                'meta' => [
                    'current_page' => $notifications->currentPage(),
                    'per_page' => $notifications->perPage(),
                    'total' => $notifications->total(),
                    'last_page' => $notifications->lastPage(),
                ]
            ]);

        } catch (\Exception $e) {
            return responseApiFalse(500, 'Failed to retrieve notifications: ' . $e->getMessage());
        }
    }
}
