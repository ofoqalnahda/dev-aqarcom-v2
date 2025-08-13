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
    path: '/api/v1/ads/list-story-ads',
    operationId: "List story Ads",
    summary: "List story ads",
    security: [['optional' => []]],
    tags: ['Story'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Success',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'status', type: 'string', example: 'success'),
                    new OA\Property(property: 'message', type: 'string', example: 'Fetched successfully'),
                    new OA\Property(
                        property: 'data',
                        properties: [
                            new OA\Property(
                                property: 'items',
                                type: 'array',
                                items: new OA\Items(ref: '#/components/schemas/UserStoryViewListModel')
                            ),
                            new OA\Property(
                                property: 'meta',
                                properties: [
                                    new OA\Property(property: 'current_page', type: 'integer', example: 1),
                                    new OA\Property(property: 'per_page', type: 'integer', example: 15),
                                    new OA\Property(property: 'total', type: 'integer', example: 120),
                                    new OA\Property(property: 'last_page', type: 'integer', example: 8),
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
class StoryAdHandler extends Handler
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
            $query = $this->adService->getStores();
            $paginated = $query->paginate($perPage);
            $items = $this->adMapper->toViewUserStoryLiseModelCollection($paginated->items());

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
