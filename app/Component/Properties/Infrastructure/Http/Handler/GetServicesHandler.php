<?php

namespace App\Component\Properties\Infrastructure\Http\Handler;

use App\Http\Controllers\Controller;
use App\Component\Properties\Application\Service\ServiceServiceInterface;
use App\Component\Properties\Application\Mapper\ServiceMapperInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: "/api/v1/properties/services",
    summary: "Get services",
    description: "Retrieve services with optional filtering by type, name, or active status",
    tags: ["Services"],
    parameters: [
        new OA\Parameter(
            name: "type",
            description: "Filter by service type",
            in: "query",
            required: false,
            schema: new OA\Schema(type: "string", enum: ["real_estate_services", "support_services"])
        ),
        new OA\Parameter(
            name: "name",
            description: "Search services by name",
            in: "query",
            required: false,
            schema: new OA\Schema(type: "string")
        ),
        new OA\Parameter(
            name: "active_only",
            description: "Filter only active services",
            in: "query",
            required: false,
            schema: new OA\Schema(type: "boolean", default: false)
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Services retrieved successfully",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "status", type: "string", example: "success"),
                    new OA\Property(property: "message", type: "string", example: "Services retrieved successfully"),
                    new OA\Property(
                        property: "data",
                        type: "array",
                        items: new OA\Items(ref: "#/components/schemas/ServiceViewModel")
                    )
                ]
            )
        ),
        new OA\Response(
            response: 500,
            description: "Internal server error",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "status", type: "string", example: "error"),
                    new OA\Property(property: "message", type: "string", example: "Failed to retrieve services"),
                    new OA\Property(property: "data", type: "array", items: new OA\Items())
                ]
            )
        )
    ]
)]
class GetServicesHandler extends Controller
{
    protected $serviceService;
    protected $serviceMapper;

    public function __construct(ServiceServiceInterface $serviceService, ServiceMapperInterface $serviceMapper)
    {
        $this->serviceService = $serviceService;
        $this->serviceMapper = $serviceMapper;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $type = $request->query('type');
            $name = $request->query('name');
            $activeOnly = $request->query('active_only', false);

            if ($type) {
                $services = $this->serviceService->getServicesByType($type);
            } elseif ($name) {
                $services = $this->serviceService->searchServicesByName($name);
            } elseif ($activeOnly) {
                $services = $this->serviceService->getActiveServices();
            } else {
                $services = $this->serviceService->getAllServices();
            }

            $viewModels = collect($services)->map(function ($service) {
                return $this->serviceMapper->toViewModel($service)->toArray();
            })->toArray();

            return response()->json([
                'status' => 'success',
                'message' => 'Services retrieved successfully',
                'data' => $viewModels
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve services',
                'data' => []
            ], 500);
        }
    }
}
