<?php

namespace App\Component\Ad\Infrastructure\Http\Handler;

use App\Component\Ad\Application\Mapper\AdMapperInterface;
use App\Component\Ad\Application\Service\AdServiceInterface;
use App\Component\Ad\Domain\Enum\MainType;
use App\Component\Ad\Presentation\ViewModel\AdViewListModel;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/ads/list-sell-ads',
    operationId: "List Sell Ads",
    summary: "List sell ads",
    security: [['optional' => []]],
    tags: ['Ads'],
    parameters: [
        new OA\Parameter(name: "lat", in: "query", required: true, schema: new OA\Schema(type: "number", format: "float")),
        new OA\Parameter(name: "lng", in: "query", required: true, schema: new OA\Schema(type: "number", format: "float")),
        new OA\Parameter(name: "search", in: "query", required: false, schema: new OA\Schema(type: "string")),
        new OA\Parameter(name: "user_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "ad_type_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "estate_type_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "city_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "region_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "neighborhood_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "usage_type_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "main_type", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "status", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "number_of_rooms", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "price", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "min_price", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "max_price", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "min_area", in: "query", required: false, schema: new OA\Schema(type: "number")),
        new OA\Parameter(name: "max_area", in: "query", required: false, schema: new OA\Schema(type: "number")),
        new OA\Parameter(name: "region_map_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "property_utilities", in: "query", required: false, schema: new OA\Schema(description: "Comma-separated list of utility IDs", type: "string")),
        new OA\Parameter(name: "per_page", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "page", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "is_special", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "is_story", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(
            name: "sort_by",
            description: "قيمة الترتيب:
                    nearest = الأقرب إليك,
                    lowest_price = الأقل سعراً,
                    highest_price = الأعلى سعراً,
                    largest_area = الأكبر مساحة,
                    smallest_area = الأصغر مساحة",
            in: "query",
            required: false,
            schema: new OA\Schema(
                type: "string",
                enum: ["nearest", "lowest_price", "highest_price", "largest_area", "smallest_area"]
            )
        ),

    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Success',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'status', type: 'string'),
                    new OA\Property(property: 'message', type: 'string'),
                    new OA\Property(
                        property: 'data',
                        properties: [
                            new OA\Property(
                                property: 'items',
                                type: 'array',
                                items: new OA\Items(ref: '#/components/schemas/AdViewListModel')
                            ),
                            new OA\Property(
                                property: 'meta',
                                properties: [
                                    new OA\Property(property: 'current_page', type: 'integer'),
                                    new OA\Property(property: 'per_page', type: 'integer'),
                                    new OA\Property(property: 'total', type: 'integer'),
                                    new OA\Property(property: 'last_page', type: 'integer'),
                                ],
                                type: 'object'
                            ),
                        ],
                        type: 'object'
                    ),
                ],
                type: 'object'
            )
        ),

        new OA\Response(response: 400, description: 'error', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
            ],
            type: 'object'
        )),
    ]
)]
class ListAdHandler extends Handler
{
    protected AdServiceInterface $adService;

    protected AdMapperInterface $adMapper;

    public function __construct(AdServiceInterface $adService, AdMapperInterface $adMapper)
    {
        $this->adService = $adService;
        $this->adMapper = $adMapper;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $perPage = (int) $request->input('per_page', 15);
            $filters =$request->all();
            $query = $this->adService->filter(MainType::SELL,$filters,true);
            $paginated = $query->paginate($perPage);
            $items = $this->adMapper->toViewLiseModelCollection($paginated->items());
//            $items = $paginated->getCollection()->map(function ($ad) {
//                return new AdViewListModel($ad);
//            });
            return  responseApi(
                data: [
                    'items' => $items,
                    'meta' => [
                        'current_page' => $paginated->currentPage(),
                        'per_page'     => $paginated->perPage(),
                        'total'        => $paginated->total(),
                        'last_page'    => $paginated->lastPage(),
                    ],
                ]
            );
        } catch (\Exception $e) {
            \Log::error('Error in List Sell Ad Handler', [
                'error'     => $e->getMessage(),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
                'code'      => $e->getCode(),
                'user_id'   => optional(Auth::user())->id
            ]);
            return responseApiFalse(
                400,
                translate('An unexpected error occurred while processing your request. Please try again. If the problem persists, contact our support team for assistance.')
            );
        }
    }

}
