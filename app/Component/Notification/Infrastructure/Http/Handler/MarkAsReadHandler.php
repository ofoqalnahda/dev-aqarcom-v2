<?php

namespace App\Component\Notification\Infrastructure\Http\Handler;

use App\Component\Notification\Application\Service\NotificationServiceInterface;
use App\Component\Notification\Infrastructure\Http\Request\MarkAsReadRequest;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/notifications/{id}/mark-as-read',
    operationId: "Mark Notification As Read",
    summary: "Mark a notification as read",
    security: [['sanctum' => []]],
    tags: ['Notifications'],
    parameters: [
        new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Success',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'status', type: 'string'),
                    new OA\Property(property: 'message', type: 'string'),
                    new OA\Property(property: 'data', type: 'object'),
                ],
                type: 'object'
            )
        ),
        new OA\Response(response: 401, description: 'Unauthorized'),
        new OA\Response(response: 404, description: 'Notification not found'),
        new OA\Response(response: 500, description: 'Server Error'),
    ],
)]
class MarkAsReadHandler extends Handler
{
    public function __construct(
        private NotificationServiceInterface $notificationService
    ) {}

    public function __invoke(MarkAsReadRequest $request, $id): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return responseApiFalse(401, 'Unauthorized');
            }

            $success = $this->notificationService->markAsRead($id, $user);
            
            if (!$success) {
                return responseApiFalse(404, 'Notification not found or you do not have permission to mark it as read');
            }

            return responseApi('Notification marked as read successfully', []);

        } catch (\Exception $e) {
            return responseApiFalse(500, 'Failed to mark notification as read: ' . $e->getMessage());
        }
    }
}
