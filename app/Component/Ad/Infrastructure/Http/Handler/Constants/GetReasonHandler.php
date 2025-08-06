<?php

namespace App\Component\Ad\Infrastructure\Http\Handler\Constants;


use App\Component\Ad\Application\Mapper\ReasonMapperInterface;
use App\Component\Ad\Application\Service\ReasonServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/constants/reasons',
    operationId: "GetReasonList",
    summary: "Get Reason List",
    tags: ['Constants'],
    responses: [
        new OA\Response(response: 200, description: 'Reasons retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/ReasonViewModel')),
            ],
            type: 'object'
        )),
    ]
)]
class GetReasonHandler extends Handler
{
    protected ReasonServiceInterface $propertyUtilityService;
    protected ReasonMapperInterface $propertyUtilityMapper;



    public function __construct(
        ReasonServiceInterface $propertyUtilityService,
        ReasonMapperInterface $propertyUtilityMapper,

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
