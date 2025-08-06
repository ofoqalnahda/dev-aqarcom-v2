<?php

namespace App\Component\Ad\Infrastructure\Http\Handler\Constants\Geography;


use App\Component\Ad\Application\Mapper\NeighborhoodMapperInterface;
use App\Component\Ad\Application\Service\NeighborhoodServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/constants/geography/neighborhoods',
    operationId: "GetNeighborhoodList",
    summary: "Get Neighborhood List",
    tags: ['Constants'],
    responses: [
        new OA\Response(response: 200, description: 'Neighborhood retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/NeighborhoodViewModel')),
            ],
            type: 'object'
        )),
    ]
)]
class GetNeighborhoodHandler extends Handler
{
    protected NeighborhoodServiceInterface $regionMapService;
    protected NeighborhoodMapperInterface $regionMapMapper;



    public function __construct(
        NeighborhoodServiceInterface $regionMapService,
        NeighborhoodMapperInterface $regionMapMapper
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
