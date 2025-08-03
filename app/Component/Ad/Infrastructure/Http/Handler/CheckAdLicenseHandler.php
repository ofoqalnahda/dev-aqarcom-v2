<?php

namespace App\Component\Ad\Infrastructure\Http\Handler;

use App\Component\Ad\Application\Mapper\AdMapperInterface;
use App\Component\Ad\Application\Service\AdServiceInterface;
use App\Component\Ad\Infrastructure\Http\Request\CheckAdLicenseRequest;
use App\Component\Ad\Presentation\ViewModel\AdExistsAdViewModel;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/ads/check-license',
    operationId: "checkLicense",
    summary: "check license",
    security: [['sanctum' => []]],
    requestBody: new OA\RequestBody(ref: '#/components/requestBodies/CheckAdLicenseRequest'),
    tags: ['Ads'],
    responses: [
        new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', ref: '#/components/schemas/AdPlatformViewModel'),
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
class CheckAdLicenseHandler extends Handler
{
    protected AdServiceInterface $adService;

    protected AdMapperInterface $adMapper;

    public function __construct(AdServiceInterface $adService, AdMapperInterface $adMapper)
    {
        $this->adService = $adService;
        $this->adMapper = $adMapper;
    }

    public function __invoke(CheckAdLicenseRequest $request): JsonResponse
    {
        $user = Auth::user();
        $license_number = $request->input('license_number');
        $exit_ad= $this->adService->CheckIsExitAd($license_number);

        if($exit_ad){
            $adViewModel = $this->adMapper->toExistsViewModel($exit_ad);
            return  responseApiFalse(
                code: 402,
                data: $adViewModel->toArray()
            );
        }
        $ad_platform=  $this->adService->CheckAdLicense($request, $user);
        if($ad_platform['Status']){
            $cacheKey = 'ad_platform_view_' . $license_number;
            $adViewModel = $this->adMapper->toPlatformViewModel($ad_platform['Body']['result']['advertisement']);
            Cache::put($cacheKey, $adViewModel->toArray(), now()->addHour());
            return responseApi(
                data: $adViewModel->toArray(),
            );
        }
        return  responseApiFalse(400,translate('Invalid license or ID. Please check and try again. If the issue persists, contact support'));
    }
}
