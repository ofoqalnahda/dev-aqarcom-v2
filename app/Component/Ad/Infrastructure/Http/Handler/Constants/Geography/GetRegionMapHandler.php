<?php

namespace App\Component\Ad\Infrastructure\Http\Handler\Constants\Geography;


use App\Component\Ad\Application\Mapper\RegionMapMapperInterface;
use App\Component\Ad\Application\Service\RegionMapServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/constants/geography/region-maps',
    operationId: "GetRegionMapList",
    summary: "Get Region For Map List",
    tags: ['Constants'],
    responses: [
        new OA\Response(response: 200, description: 'Region For Map retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/RegionMapViewModel')),
            ],
            type: 'object'
        )),
    ]
)]
class GetRegionMapHandler extends Handler
{
    protected RegionMapServiceInterface $regionMapService;
    protected RegionMapMapperInterface $regionMapMapper;



    public function __construct(
        RegionMapServiceInterface $regionMapService,
        RegionMapMapperInterface $regionMapMapper
    ) {
        $this->regionMapService = $regionMapService;
        $this->regionMapMapper = $regionMapMapper;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $date=$this->regionMapMapper->toViewModelCollection($this->regionMapService->index());
        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $date,
        ]);
    }
}
