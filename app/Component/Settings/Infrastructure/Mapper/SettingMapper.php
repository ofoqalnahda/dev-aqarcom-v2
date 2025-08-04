<?php

namespace App\Component\Settings\Infrastructure\Mapper;

use App\Component\Settings\Application\Mapper\SettingMapperInterface;
use App\Component\Settings\Data\Entity\Setting;
use App\Component\Settings\Presentation\ViewModel\SettingViewModel;
use Illuminate\Database\Eloquent\Collection;

class SettingMapper implements SettingMapperInterface
{
    public function toViewModel(Setting $setting): SettingViewModel
    {
        return new SettingViewModel($setting);
    }
    
    public function toViewModelCollection(Collection $settings): array
    {
        return array_map(function ($setting) {
            return $this->toViewModel($setting);
        }, $settings->all());
    }
} 