<?php

namespace App\Component\Settings\Application\Repository;

use App\Component\Settings\Data\Entity\Setting;
use Illuminate\Database\Eloquent\Collection;

interface SettingRepositoryInterface
{
    public function findByKey(string $key, ?int $userId = null): ?Setting;
    
    public function findByUserId(int $userId): Collection;
    
    public function findGlobalSettings(): Collection;
    
    public function create(array $data): Setting;
    
    public function update(Setting $setting, array $data): Setting;
    
    public function delete(Setting $setting): bool;
} 