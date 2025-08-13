<?php

namespace App\Component\Ad\Infrastructure\Http\Handler;

use App\Component\Ad\Application\Mapper\AdMapperInterface;
use App\Component\Ad\Application\Service\AdServiceInterface;
use App\Component\Ad\Domain\Enum\MainType;
use App\Component\Properties\Application\Mapper\ServiceMapperInterface;
use App\Component\Properties\Application\Service\ServiceServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/home',
    operationId: "Home",
    summary: "Get home ads: special, nearest and services",
    security: [['optional' => []]],
    tags: ['Home'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Success',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'status', type: 'string', example: 'success'),
                    new OA\Property(property: 'message', type: 'string', example: 'Fetched successfully'),
                    new OA\Property(
                        property: 'data',
                        properties: [
                            new OA\Property(
                                property: 'special',
                                type: 'array',
                                items: new OA\Items(ref: '#/components/schemas/AdViewListModel')
                            ),
                            new OA\Property(
                                property: 'nearest',
                                type: 'array',
                                items: new OA\Items(ref: '#/components/schemas/AdViewListModel')
                            ),
                            new OA\Property(
                                property: 'services',
                                type: 'array',
                                items: new OA\Items(ref: '#/components/schemas/ServiceViewModel')
                            ),
                        ],
                        type: 'object'
                    ),
                ]
            )
        ),
        new OA\Response(
            response: 400,
            description: 'Error',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'status', type: 'string'),
                    new OA\Property(property: 'message', type: 'string'),
                ]
            )
        ),
    ]
)]
class HomeAdHandler extends Handler
{
    protected AdServiceInterface $adService;
    protected AdMapperInterface $adMapper;
    protected ServiceServiceInterface $serviceService;
    protected ServiceMapperInterface $serviceMapper;

    public function __construct(
        AdServiceInterface $adService,
        AdMapperInterface $adMapper,
        ServiceServiceInterface $serviceService,
        ServiceMapperInterface $serviceMapper
    ) {
        $this->adService = $adService;
        $this->adMapper = $adMapper;
        $this->serviceService = $serviceService;
        $this->serviceMapper = $serviceMapper;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $perPage = (int) $request->input('per_page', 10);

        try {
            // Special ads randomly
            $specialAds = $this->adService->filter(MainType::SELL, ['is_special' => true], true)
                ->inRandomOrder()
                ->paginate($perPage)->items();
            $special = $this->adMapper->toViewLiseModelCollection($specialAds);

            // Nearest ads
            $nearestAds = $this->adService->filter(MainType::SELL, ['sort_by' => 'nearest'], true)
                ->limit($perPage)
                ->paginate($perPage)->items();
            $nearest = $this->adMapper->toViewLiseModelCollection($nearestAds);

            // Services
            $services = $this->serviceService->getServicesByType('real_estate_services');
            $serviceViewModels = collect($services)
                ->map(fn($service) => $this->serviceMapper->toViewModel($service)->toArray())
                ->toArray();

            return responseApi(data: [
                'special' => $special,
                'nearest' => $nearest,
                'services' => $serviceViewModels,
            ]);

        } catch (\Exception $e) {
            dd($e);
            Log::error('Error in HomeAdHandler', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode(),
                'user_id' => optional(Auth::user())->id,
            ]);

            return responseApiFalse(
                400,
                translate('An unexpected error occurred while processing your request. Please try again. If the problem persists, contact our support team for assistance.')
            );
        }
    }
}
