<?php

namespace App\Component\Ad\Infrastructure\Http\Handler\Constants;


use App\Component\Ad\Application\Mapper\EstateTypeMapperInterface;
use App\Component\Ad\Application\Service\EstateTypeServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/constants/estate-types',
    operationId: "GetEstateTypeList",
    summary: "Get Estate Type List",
    tags: ['Constants'],
    responses: [
        new OA\Response(response: 200, description: 'Estate Types retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/EstateTypeViewModel')),
            ],
            type: 'object'
        )),
    ]
)]
class GetEstateTypeHandler extends Handler
{
    protected EstateTypeServiceInterface $estateTypeService;
    protected EstateTypeMapperInterface $estateTypeMapper;



    public function __construct(
        EstateTypeServiceInterface $estateTypeService,
        EstateTypeMapperInterface $estateTypeMapper,

    ) {
        $this->estateTypeService = $estateTypeService;
        $this->estateTypeMapper = $estateTypeMapper;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $date=$this->estateTypeMapper->toViewModelCollection($this->estateTypeService->index());
        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $date,
        ]);
    }
}
