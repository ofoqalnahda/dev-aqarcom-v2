<?php

namespace App\Component\Ad\Infrastructure\Http\Handler;

use App\Component\Ad\Application\Mapper\AdMapperInterface;
use App\Component\Ad\Application\Service\AdServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/ads/{ad}/toggle-view',
    operationId: "ToggleView",
    summary: "toggle view ads",
    security: [['sanctum' => []]],
    tags: ['Ads'],
    responses: [
        new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(
                    property: 'data',
                    properties: [
                        new OA\Property(property: 'is_view', type: 'boolean', example: true),
                    ],
                    type: 'object'
                ),
            ],
            type: 'object'
        )),
        new OA\Response(response: 400, description: 'error', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
            ],
            type: 'object'
        )),
    ]
)]
class ToggleViewHandler extends Handler
{
    protected AdServiceInterface $adService;

    protected AdMapperInterface $adMapper;

    public function __construct(AdServiceInterface $adService, AdMapperInterface $adMapper)
    {
        $this->adService = $adService;
        $this->adMapper = $adMapper;
    }

    public function __invoke($ad): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $isView = $user->viewAds()->where('ad_id', $ad)->exists();

            if (!$isView) {
                $user->viewAds()->attach($ad);
                $is_view = true;
            }
            DB::commit();
            return responseApi(
                data: [
                    'is_view' => $is_view,
                ],
            );
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in StoreSellAdHandler', [
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
