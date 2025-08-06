<?php

namespace App\Component\Ad\Infrastructure\Http\Handler\Constants;


use App\Component\Ad\Application\Mapper\PropertyUtilityMapperInterface;
use App\Component\Ad\Application\Service\PropertyUtilityServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/constants/property-utilities',
    operationId: "GetPropertyUtilityList",
    summary: "Get Property Utility List",
    tags: ['Constants'],
    responses: [
        new OA\Response(response: 200, description: 'Estate Types retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/PropertyUtilityViewModel')),
            ],
            type: 'object'
        )),
    ]
)]
class GetPropertyUtilityHandler extends Handler
{
    protected PropertyUtilityServiceInterface $propertyUtilityService;
    protected PropertyUtilityMapperInterface $propertyUtilityMapper;



    public function __construct(
        PropertyUtilityServiceInterface $propertyUtilityService,
        PropertyUtilityMapperInterface $propertyUtilityMapper,

    ) {
        $this->propertyUtilityService = $propertyUtilityService;
        $this->propertyUtilityMapper = $propertyUtilityMapper;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $date=$this->propertyUtilityMapper->toViewModelCollection($this->propertyUtilityService->index());
        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $date,
        ]);
    }
}
