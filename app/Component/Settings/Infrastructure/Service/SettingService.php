<?php

namespace App\Component\Settings\Infrastructure\Service;

use App\Component\Settings\Application\Service\SettingServiceInterface;
use App\Component\Settings\Application\Repository\SettingRepositoryInterface;
use App\Component\Settings\Data\Entity\Setting;

class SettingService implements SettingServiceInterface
{
    protected SettingRepositoryInterface $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getUserSettings(int $userId): array
    {
        return $this->settingRepository->findByUserId($userId);
    }
    
    public function getGlobalSettings(): array
    {
        return $this->settingRepository->findGlobalSettings();
    }
    
    public function updateUserSetting(int $userId, string $key, mixed $value): Setting
    {
        $setting = $this->settingRepository->findByKey($key, $userId);
        
        if ($setting) {
            return $this->settingRepository->update($setting, ['value' => $value]);
        }
        
        return $this->settingRepository->create([
            'key' => $key,
            'value' => $value,
            'user_id' => $userId,
            'type' => 'user',
            'is_public' => false,
        ]);
    }
    
    public function updateGlobalSetting(string $key, mixed $value): Setting
    {
        $setting = $this->settingRepository->findByKey($key);
        
        if ($setting) {
            return $this->settingRepository->update($setting, ['value' => $value]);
        }
        
        return $this->settingRepository->create([
            'key' => $key,
            'value' => $value,
            'user_id' => null,
            'type' => 'global',
            'is_public' => true,
        ]);
    }
    
    public function getSetting(string $key, ?int $userId = null): ?Setting
    {
        return $this->settingRepository->findByKey($key, $userId);
    }
} 