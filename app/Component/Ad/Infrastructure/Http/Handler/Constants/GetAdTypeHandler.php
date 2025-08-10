<?php

namespace App\Component\Ad\Infrastructure\Http\Handler\Constants;


use App\Component\Ad\Application\Mapper\AdTypeMapperInterface;
use App\Component\Ad\Application\Mapper\EstateTypeMapperInterface;
use App\Component\Ad\Application\Mapper\PropertyUtilityMapperInterface;
use App\Component\Ad\Application\Mapper\UsageTypeMapperInterface;
use App\Component\Ad\Application\Service\AdServiceInterface;
use App\Component\Ad\Application\Service\AdTypeServiceInterface;
use App\Component\Ad\Application\Service\EstateTypeServiceInterface;
use App\Component\Ad\Application\Service\PropertyUtilityServiceInterface;
use App\Component\Ad\Application\Service\UsageTypeServiceInterface;
use App\Component\Ad\Domain\Enum\MainType;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/constants/ad-types',
    operationId: "GetAdTypeList",
    summary: "Get Ad Type List",
    tags: ['Constants'],
    parameters: [
        new OA\Parameter(
            name: "type",
            description: "Type",
            in: "query",
            required: true,
            schema: new OA\Schema(
                type: 'string',
                enum: [
                    MainType::SELL,
                    MainType::Buy
                ]
            ),
            example: MainType::SELL
        )
    ],
    responses: [
        new OA\Response(response: 200, description: 'Ad Types retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/AdTypeViewModel')),
            ],
            type: 'object'
        )),
    ]
)]
class GetAdTypeHandler extends Handler
{
    protected AdTypeServiceInterface $adTypeService;
    protected AdTypeMapperInterface $adTypeMapper;



    public function __construct(
        AdTypeServiceInterface $adTypeService,
        AdTypeMapperInterface $adTypeMapper,

    ) {
        $this->adTypeService = $adTypeService;
        $this->adTypeMapper = $adTypeMapper;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $date=$this->adTypeMapper->toViewModelCollection($this->adTypeService->getByType($request->type));
        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $date,
        ]);
    }
}
