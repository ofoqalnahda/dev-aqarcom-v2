<?php

namespace App\Component\Properties\Infrastructure\Http\Handler;

use App\Http\Controllers\Controller;
use App\Component\Properties\Infrastructure\Http\Request\UpdateServiceRequest;
use App\Component\Properties\Application\Service\ServiceServiceInterface;
use App\Component\Properties\Application\Mapper\ServiceMapperInterface;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Put(
    path: "/api/v1/properties/services/{id}",
    summary: "Update a service",
    description: "Updates an existing service with the specified ID",
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
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(ref: "#/components/schemas/UpdateServiceRequest")
    ),
    responses: [
        new OA\Response(
            response: 200,
            description: "Service updated successfully",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "status", type: "string", example: "success"),
                    new OA\Property(property: "message", type: "string", example: "Service updated successfully"),
                    new OA\Property(property: "data", ref: "#/components/schemas/ServiceViewModel")
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
            response: 422,
            description: "Validation error",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "status", type: "string", example: "error"),
                    new OA\Property(property: "message", type: "string"),
                    new OA\Property(property: "errors", type: "object")
                ]
            )
        ),
        new OA\Response(
            response: 500,
            description: "Internal server error",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "status", type: "string", example: "error"),
                    new OA\Property(property: "message", type: "string", example: "Failed to update service"),
                    new OA\Property(property: "data", type: "array", items: new OA\Items())
                ]
            )
        )
    ]
)]
class UpdateServiceHandler extends Controller
{
    protected $serviceService;
    protected $serviceMapper;

    public function __construct(ServiceServiceInterface $serviceService, ServiceMapperInterface $serviceMapper)
    {
        $this->serviceService = $serviceService;
        $this->serviceMapper = $serviceMapper;
    }

    public function __invoke(UpdateServiceRequest $request, int $id): JsonResponse
    {
        try {
            $service = $this->serviceService->updateService($id, $request->validated());

            if (!$service) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Service not found',
                    'data' => []
                ], 404);
            }

            $viewModel = $this->serviceMapper->toViewModel($service);

            return response()->json([
                'status' => 'success',
                'message' => 'Service updated successfully',
                'data' => $viewModel->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update service',
                'data' => []
            ], 500);
        }
    }
}
