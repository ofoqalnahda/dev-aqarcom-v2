<?php

namespace App\Component\Ad\Infrastructure\Http\Handler\Constants;


use App\Component\Ad\Application\Mapper\UsageTypeMapperInterface;
use App\Component\Ad\Application\Service\UsageTypeServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/constants/usage-types',
    operationId: "GetUsageTypeList",
    summary: "Get Usage Type List",
    tags: ['Constants'],
    responses: [
        new OA\Response(response: 200, description: 'Usage Types retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/UsageTypeViewModel')),
            ],
            type: 'object'
        )),
    ]
)]
class GetUsageTypeHandler extends Handler
{
    protected UsageTypeServiceInterface $propertyUtilityService;
    protected UsageTypeMapperInterface $propertyUtilityMapper;



    public function __construct(
        UsageTypeServiceInterface $propertyUtilityService,
        UsageTypeMapperInterface $propertyUtilityMapper,

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
