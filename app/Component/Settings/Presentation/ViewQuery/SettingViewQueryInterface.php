<?php

namespace App\Component\Settings\Presentation\ViewQuery;

interface SettingViewQueryInterface
{
    public function getUserSettings(int $userId): array;
    
    public function getGlobalSettings(): array;
} 