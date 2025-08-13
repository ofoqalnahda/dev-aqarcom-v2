<?php

namespace App\Component\Properties\Infrastructure\Http\Handler;

use App\Http\Controllers\Controller;
use App\Component\Properties\Infrastructure\Http\Request\CreateServiceRequest;
use App\Component\Properties\Application\Service\ServiceServiceInterface;
use App\Component\Properties\Application\Mapper\ServiceMapperInterface;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: "/api/v1/properties/services",
    description: "Creates a new service with the specified type and name",
    summary: "Create a new service",
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(ref: "#/components/schemas/CreateServiceRequest")
    ),
    tags: ["Services"],
    responses: [
        new OA\Response(
            response: 201,
            description: "Service created successfully",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "status", type: "string", example: "success"),
                    new OA\Property(property: "message", type: "string", example: "Service created successfully"),
                    new OA\Property(property: "data", ref: "#/components/schemas/ServiceViewModel")
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
                    new OA\Property(property: "message", type: "string", example: "Failed to create service"),
                    new OA\Property(property: "data", type: "array", items: new OA\Items())
                ]
            )
        )
    ]
)]
class CreateServiceHandler extends Controller
{
    protected $serviceService;
    protected $serviceMapper;

    public function __construct(ServiceServiceInterface $serviceService, ServiceMapperInterface $serviceMapper)
    {
        $this->serviceService = $serviceService;
        $this->serviceMapper = $serviceMapper;
    }

    public function __invoke(CreateServiceRequest $request): JsonResponse
    {
        try {
            $service = $this->serviceService->createService($request->validated());
            if ($request->has('image')) {
                    $service->addMediaFromRequest('image')->toMediaCollection('images');
            }

            $viewModel = $this->serviceMapper->toViewModel($service);

            return response()->json([
                'status' => 'success',
                'message' => 'Service created successfully',
                'data' => $viewModel->toArray()
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create service',
                'data' => []
            ], 500);
        }
    }
}
