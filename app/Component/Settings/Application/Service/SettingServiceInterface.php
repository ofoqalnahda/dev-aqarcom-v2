<?php

namespace App\Component\Settings\Application\Service;

use App\Component\Settings\Data\Entity\Setting;

interface SettingServiceInterface
{
    public function getUserSettings(int $userId): array;
    
    public function getGlobalSettings(): array;
    
    public function updateUserSetting(int $userId, string $key, mixed $value): Setting;
    
    public function updateGlobalSetting(string $key, mixed $value): Setting;
    
    public function getSetting(string $key, ?int $userId = null): ?Setting;
} 