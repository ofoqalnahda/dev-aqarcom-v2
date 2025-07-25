<?php

namespace App\Component\Settings\Infrastructure\Http\Handler;

use App\Component\Settings\Infrastructure\Http\Request\UpdateSettingRequest;
use App\Component\Settings\Application\Service\SettingServiceInterface;
use App\Component\Settings\Application\Mapper\SettingMapperInterface;
use App\Libraries\Base\Http\Handler;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/settings/user',
    requestBody: new OA\RequestBody(ref: '#/components/requestBodies/UpdateSettingRequest'),
    tags: ['Settings'],
    responses: [
        new OA\Response(response: 200, description: 'Setting updated successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', ref: '#/components/schemas/SettingViewModel'),
            ],
            type: 'object'
        )),
    ]
)]
class UpdateUserSettingHandler extends Handler
{
    protected SettingServiceInterface $settingService;
    protected SettingMapperInterface $settingMapper;

    public function __construct(
        SettingServiceInterface $settingService,
        SettingMapperInterface $settingMapper
    ) {
        $this->settingService = $settingService;
        $this->settingMapper = $settingMapper;
    }

    public function __invoke(UpdateSettingRequest $request): \Illuminate\Http\JsonResponse
    {
        $userId = $request->user()->id;
        $key = $request->input('key');
        $value = $request->input('value');

        $setting = $this->settingService->updateUserSetting($userId, $key, $value);
        $settingViewModel = $this->settingMapper->toViewModel($setting);

        return response()->json([
            'status' => 'success',
            'message' => 'Setting updated successfully',
            'data' => $settingViewModel->toArray(),
        ]);
    }
} 