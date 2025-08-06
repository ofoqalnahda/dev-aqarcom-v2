<?php

namespace App\Component\Ad\Infrastructure\Http\Handler\Constants\Geography;


use App\Component\Ad\Application\Mapper\CityMapperInterface;
use App\Component\Ad\Application\Service\CityServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/constants/geography/cities',
    operationId: "GetCityList",
    summary: "Get City List",
    tags: ['Constants'],
    responses: [
        new OA\Response(response: 200, description: 'City retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/CityViewModel')),
            ],
            type: 'object'
        )),
    ]
)]
class GetCityHandler extends Handler
{
    protected CityServiceInterface $regionService;
    protected CityMapperInterface $regionMapper;



    public function __construct(
        CityServiceInterface $regionService,
        CityMapperInterface $regionMapper
    ) {
        $this->regionService = $regionService;
        $this->regionMapper = $regionMapper;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $date=$this->regionMapper->toViewModelCollection($this->regionService->index());
        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $date,
        ]);
    }
}
