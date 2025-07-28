<?php

namespace App\Component\Ad\Infrastructure\Http\Handler;

use App\Component\Ad\Application\Mapper\AdMapperInterface;
use App\Component\Ad\Application\Service\AdServiceInterface;
use App\Component\Ad\Domain\Enum\MainType;
use App\Component\Ad\Infrastructure\Http\Request\StoreSellAdRequest;
use App\Component\Ad\Presentation\ViewModel\AdExistsAdViewModel;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/ads/store-sell-ads',
    operationId: "storeSellAds",
    summary: "store sell ads",
    security: [['sanctum' => []]],
    requestBody: new OA\RequestBody(ref: '#/components/requestBodies/StoreSellAdRequest'),
    tags: ['Ads'],
    responses: [
        new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', title: 'string',example: 'slug ad'),
            ],
            type: 'object'
        )),
        new OA\Response(response: 402, description: 'Exit ad', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', ref: '#/components/schemas/AdExistsAdViewModel'),

            ],
            type: 'object'
        )),
        new OA\Response(response: 400, description: 'Validation error', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
            ],
            type: 'object'
        )),
    ]
)]
class StoreSellAdHandler extends Handler
{
    protected AdServiceInterface $adService;

    protected AdMapperInterface $adMapper;

    public function __construct(AdServiceInterface $adService, AdMapperInterface $adMapper)
    {
        $this->adService = $adService;
        $this->adMapper = $adMapper;
    }

    public function __invoke(StoreSellAdRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();


            $license_number = $request->input('license_number');
            $exit_ad = $this->adService->CheckIsExitAd($license_number);
            if ($exit_ad) {
                $adViewModel = $this->adMapper->toExistsViewModel($exit_ad);
                return responseApiFalse(
                    code: 402,
                    data: $adViewModel->toArray()
                );
            }

            $ad = $this->adService->create(MainType::SELL, $request->validated(), $user);
            if ($request->hasFile('main_image')) {
                $ad->addMediaFromRequest('main_image')->toMediaCollection('main_image');
            }

            if ($request->has('images')) {
                foreach ($request->file('images') as $image) {
                    $ad->addMedia($image)->toMediaCollection('images');
                }
            }

            if ($request->hasFile('video')) {
                $ad->addMediaFromRequest('video')->toMediaCollection('video');
            }
            $slug=$ad->slug;
            $cacheKey = 'ad_platform_view_' . $license_number;
            $cacheKey_ch = 'ad_check_' . $license_number;

            Cache::forget($cacheKey);
            Cache::forget($cacheKey_ch);
            DB::commit();
            return responseApi(
                data: $slug,
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
