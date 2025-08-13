<?php

namespace App\Component\Properties\Infrastructure\Http\Handler;

use App\Http\Controllers\Controller;
use App\Component\Properties\Application\Service\ServiceServiceInterface;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Delete(
    path: "/api/v1/properties/services/{id}",
    summary: "Delete a service",
    description: "Deletes an existing service with the specified ID",
    tags: ["Services"],
    parameters: [
        new OA\Parameter(
            name: "id",
            description: "Service ID",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "integer")
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Service deleted successfully",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "status", type: "string", example: "success"),
                    new OA\Property(property: "message", type: "string", example: "Service deleted successfully"),
                    new OA\Property(property: "data", type: "array", items: new OA\Items())
                ]
            )
        ),
        new OA\Response(
            response: 404,
            description: "Service not found",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "status", type: "string", example: "error"),
                    new OA\Property(property: "message", type: "string", example: "Service not found"),
                    new OA\Property(property: "data", type: "array", items: new OA\Items())
                ]
            )
        ),
        new OA\Response(
            response: 500,
            description: "Internal server error",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "status", type: "string", example: "error"),
                    new OA\Property(property: "message", type: "string", example: "Failed to delete service"),
                    new OA\Property(property: "data", type: "array", items: new OA\Items())
                ]
            )
        )
    ]
)]
class DeleteServiceHandler extends Controller
{
    protected $serviceService;

    public function __construct(ServiceServiceInterface $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function __invoke(int $id): JsonResponse
    {
        try {
            $deleted = $this->serviceService->deleteService($id);

            if (!$deleted) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Service not found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Service deleted successfully',
                'data' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete service',
                'data' => []
            ], 500);
        }
    }
}
