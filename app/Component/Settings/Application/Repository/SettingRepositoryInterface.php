<?php

namespace App\Component\Settings\Application\Repository;

use App\Component\Settings\Data\Entity\Setting;

interface SettingRepositoryInterface
{
    public function findByKey(string $key, ?int $userId = null): ?Setting;
    
    public function findByUserId(int $userId): array;
    
    public function findGlobalSettings(): array;
    
    public function create(array $data): Setting;
    
    public function update(Setting $setting, array $data): Setting;
    
    public function delete(Setting $setting): bool;
} 