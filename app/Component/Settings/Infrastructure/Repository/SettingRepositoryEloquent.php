<?php

namespace App\Component\Settings\Infrastructure\Repository;

use App\Component\Settings\Application\Repository\SettingRepositoryInterface;
use App\Component\Settings\Data\Entity\Setting;
use Illuminate\Database\Eloquent\Collection;

class SettingRepositoryEloquent implements SettingRepositoryInterface
{
    public function findByKey(string $key, ?int $userId = null): ?Setting
    {
        $query = Setting::where('key', $key);
        
        if ($userId !== null) {
            $query->where('user_id', $userId);
        } else {
            $query->whereNull('user_id');
        }
        
        return $query->first();
    }
    
    public function findByUserId(int $userId): Collection
    {
        return Setting::where('user_id', $userId)->get();
    }
    
    public function findGlobalSettings(): Collection
    {
        return Setting::whereNull('user_id')->get();
    }
    
    public function create(array $data): Setting
    {
        return Setting::create($data);
    }
    
    public function update(Setting $setting, array $data): Setting
    {
        $setting->update($data);
        return $setting->fresh();
    }
    
    public function delete(Setting $setting): bool
    {
        return $setting->delete();
    }
} 