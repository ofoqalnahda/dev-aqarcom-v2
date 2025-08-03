<?php

namespace App\Component\Settings\Infrastructure\ViewQuery;

use App\Component\Settings\Presentation\ViewQuery\SettingViewQueryInterface;
use App\Component\Settings\Application\Service\SettingServiceInterface;
use App\Component\Settings\Application\Mapper\SettingMapperInterface;

class SettingViewQuery implements SettingViewQueryInterface
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

    public function getUserSettings(int $userId): array
    {
        $settings = $this->settingService->getUserSettings($userId);
        return $this->settingMapper->toViewModelCollection($settings);
    }
    
    public function getGlobalSettings(): array
    {
        $settings = $this->settingService->getGlobalSettings();
        return $this->settingMapper->toViewModelCollection($settings);
    }
} 