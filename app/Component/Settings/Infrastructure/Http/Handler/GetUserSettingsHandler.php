<?php

namespace App\Component\Settings\Infrastructure\Http\Handler;

use App\Component\Settings\Presentation\ViewQuery\SettingViewQueryInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/settings/user',
    tags: ['Settings'],
    responses: [
        new OA\Response(response: 200, description: 'User settings retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/SettingViewModel')),
            ],
            type: 'object'
        )),
    ]
)]
class GetUserSettingsHandler extends Handler
{
    protected SettingViewQueryInterface $settingViewQuery;

    public function __construct(SettingViewQueryInterface $settingViewQuery)
    {
        $this->settingViewQuery = $settingViewQuery;
    }

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $userId = $request->user()->id;
        $settings = $this->settingViewQuery->getUserSettings($userId);

        return response()->json([
            'status' => 'success',
            'message' => 'User settings retrieved successfully',
            'data' => array_map(fn($setting) => $setting->toArray(), $settings),
        ]);
    }
} 