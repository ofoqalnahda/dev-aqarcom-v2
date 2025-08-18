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
    path: '/api/v1/ads/list-buy-ads',
    operationId: "List Buy Ads",
    summary: "List buy ads",
    security: [['optional' => []]],
    tags: ['Ads'],
    parameters: [
        new OA\Parameter(name: "search", in: "query", required: false, schema: new OA\Schema(type: "string")),
        new OA\Parameter(name: "ad_type_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "estate_type_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "city_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "region_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "neighborhood_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "per_page", in: "query", required: false, schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "page", in: "query", required: false, schema: new OA\Schema(type: "integer")),

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
                                items: new OA\Items(ref: '#/components/schemas/AdBuyViewListModel')
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
class ListAdBuyHandler extends Handler
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
            $query = $this->adService->filter(MainType::Buy,$filters);
            $paginated = $query->paginate($perPage);
            $items = $this->adMapper->toViewBuyLiseModelCollection($paginated->items());
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
