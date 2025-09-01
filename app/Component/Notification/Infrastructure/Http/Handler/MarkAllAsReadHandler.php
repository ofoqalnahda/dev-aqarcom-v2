<?php

namespace App\Component\Notification\Infrastructure\Http\Handler;

use App\Component\Notification\Application\Service\NotificationServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/notifications/mark-all-as-read',
    operationId: "Mark All Notifications As Read",
    summary: "Mark all user notifications as read",
    security: [['sanctum' => []]],
    tags: ['Notifications'],
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
                            new OA\Property(property: 'marked_count', type: 'integer'),
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
class MarkAllAsReadHandler extends Handler
{
    public function __construct(
        private NotificationServiceInterface $notificationService
    ) {}

    public function __invoke(): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return responseApiFalse(401, 'Unauthorized');
            }

            $markedCount = $this->notificationService->markAllAsRead($user);

            return responseApi("Successfully marked {$markedCount} notifications as read", [
                'marked_count' => $markedCount
            ]);

        } catch (\Exception $e) {
            return responseApiFalse(500, 'Failed to mark notifications as read: ' . $e->getMessage());
        }
    }
}
